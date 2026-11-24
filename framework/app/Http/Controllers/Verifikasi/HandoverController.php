<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verifikasi\StoreHandoverRequest;
use App\Models\Claim;
use App\Models\HandoverRecord;
use App\Models\Item;
use App\Models\User;
use App\Services\NotifikasiService;
use App\Services\StatusHistoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HandoverController extends Controller
{
    public function index(Request $request): View
    {
        abort_if(!auth()->user()->isPetugas(), 403, 'Akses hanya diizinkan untuk Petugas.');

        // Pengajuan berstatus DITERIMA yang laporannya belum selesai
        $claims = Claim::with(['item.category', 'item.user', 'submitter'])
            ->where('status', Claim::STATUS_DITERIMA)
            ->whereHas('item', function ($query) {
                $query->where('status', '!=', Item::STATUS_SELESAI);
            })
            ->doesntHave('handoverRecord')
            ->orderBy('verified_at', 'asc')
            ->paginate(10);

        return view('verifikasi.handovers.index', compact('claims'));
    }

    public function create(Claim $claim): View|RedirectResponse
    {
        abort_if(!auth()->user()->isPetugas(), 403, 'Akses hanya diizinkan untuk Petugas.');

        // Tolak jika pengajuan belum diterima, laporan sudah selesai, atau handover sudah ada
        if ($claim->status !== Claim::STATUS_DITERIMA) {
            return redirect()
                ->route('handovers.index')
                ->with('error', "Pengajuan {$claim->kode} belum berstatus diterima.");
        }

        if ($claim->item->status === Item::STATUS_SELESAI) {
            return redirect()
                ->route('handovers.index')
                ->with('error', "Laporan {$claim->item->kode} sudah selesai diserahterimakan.");
        }

        if ($claim->handoverRecord()->exists()) {
            return redirect()
                ->route('handovers.index')
                ->with('error', "Catatan serah terima untuk pengajuan {$claim->kode} sudah tercatat sebelumnya.");
        }

        $claim->load(['item.category', 'item.user', 'submitter', 'verifier']);

        // Tentukan PENERIMA YANG SAH:
        // - Laporan Found: penerima = pengaju klaim (claim.submitter)
        // - Laporan Lost: penerima = pembuat laporan Lost (item.user)
        $receiver = $claim->item->type === Item::TYPE_FOUND
            ? $claim->submitter
            : $claim->item->user;

        return view('verifikasi.handovers.create', compact('claim', 'receiver'));
    }

    public function store(StoreHandoverRequest $request, Claim $claim): RedirectResponse
    {
        abort_if(!auth()->user()->isPetugas(), 403, 'Akses hanya diizinkan untuk Petugas.');

        // Validasi kondisi sebelum simpan
        if ($claim->status !== Claim::STATUS_DITERIMA || $claim->item->status === Item::STATUS_SELESAI || $claim->handoverRecord()->exists()) {
            return redirect()
                ->route('handovers.index')
                ->with('error', 'Proses serah terima tidak valid atau telah selesai.');
        }

        // Tentukan penerima yang sah
        $receiverId = $claim->item->type === Item::TYPE_FOUND
            ? $claim->submitter_id
            : $claim->item->user_id;

        $receiver = User::findOrFail($receiverId);

        DB::transaction(function () use ($request, $claim, $receiverId, $receiver) {
            // 1. Buat catatan serah terima
            HandoverRecord::create([
                'item_id' => $claim->item_id,
                'claim_id' => $claim->id,
                'receiver_id' => $receiverId,
                'officer_id' => auth()->id(),
                'handed_over_at' => now(),
                'return_note' => $request->return_note,
            ]);

            // 2. Ubah status laporan ke Item::STATUS_SELESAI lewat StatusHistoryService (Aturan 7)
            StatusHistoryService::ubah(
                $claim->item,
                Item::STATUS_SELESAI,
                auth()->user(),
                'Barang diserahterimakan'
            );

            // 3. Kirim notifikasi ke penerima
            NotifikasiService::kirim(
                $receiver,
                "Serah Terima Selesai ({$claim->item->kode})",
                "Barang {$claim->item->kode} ({$claim->item->name}) telah resmi diserahterimakan kepada Anda oleh petugas.",
                null,
                'success'
            );
        });

        return redirect()
            ->route('handovers.index')
            ->with('success', "Proses serah terima untuk barang {$claim->item->kode} berhasil dicatat dan status laporan telah diperbarui menjadi Selesai.");
    }

    public function show(HandoverRecord $handover): View
    {
        abort_if(!auth()->user()->isPetugas() && !auth()->user()->isAdmin(), 403, 'Akses hanya diizinkan untuk Petugas dan Admin.');
        $handover->load(['item', 'claim', 'receiver', 'officer']);
        return view('verification.handover.show', compact('handover'));
    }
}

<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\Item;
use App\Services\NotifikasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClaimVerificationController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        abort_if(!$user || (!$user->isAdmin() && !$user->isPetugas()), 403, 'Akses hanya untuk Admin dan Petugas.');

        $query = Claim::with(['item.category', 'item.user', 'submitter'])
            ->where('status', Claim::STATUS_DIAJUKAN);

        // Filter jenis (klaim / penemuan)
        if ($request->filled('type') && in_array($request->type, [Claim::TYPE_KLAIM, Claim::TYPE_PENEMUAN], true)) {
            $query->where('type', $request->type);
        }

        $claims = $query->orderBy('created_at', 'asc')->paginate(10);

        return view('verifikasi.claims.index', compact('claims'));
    }

    public function show(Claim $claim): View
    {
        $user = auth()->user();
        abort_if(!$user || (!$user->isAdmin() && !$user->isPetugas()), 403, 'Akses hanya untuk Admin dan Petugas.');

        $claim->load(['item.category', 'item.user', 'submitter', 'verifier']);

        return view('verifikasi.claims.show', compact('claim'));
    }

    public function accept(Request $request, Claim $claim): RedirectResponse
    {
        $user = auth()->user();
        abort_if(!$user || (!$user->isAdmin() && !$user->isPetugas()), 403, 'Akses hanya untuk Admin dan Petugas.');

        // Hanya boleh bila status pengajuan masih diajukan
        if ($claim->status !== Claim::STATUS_DIAJUKAN) {
            return redirect()
                ->route('verifikasi.claims.index')
                ->with('error', "Pengajuan {$claim->kode} tidak dapat diproses karena status saat ini: {$claim->statusLabel()}.");
        }

        // Dan laporan terkait masih dipublikasikan (SRS NFR-08: Laporan selesai tidak dapat diproses)
        if ($claim->item->status !== Item::STATUS_DIPUBLIKASIKAN) {
            return redirect()
                ->route('verifikasi.claims.index')
                ->with('error', "Pengajuan {$claim->kode} tidak dapat diterima karena status laporan terkait: {$claim->item->statusLabel()}.");
        }

        $claim->update([
            'status' => Claim::STATUS_DITERIMA,
            'verifier_id' => $user->id,
            'verified_at' => now(),
        ]);

        // Notifikasi ke pengaju
        NotifikasiService::kirim(
            $claim->submitter,
            "Pengajuan {$claim->kode} diterima",
            "Pengajuan {$claim->kode} diterima, temui petugas dengan membawa identitas untuk proses verifikasi fisik dan serah terima.",
            route('claims.evidence', $claim),
            'success'
        );

        // Untuk penemuan yang diterima: kirim juga notifikasi ke pembuat laporan Lost
        if ($claim->type === Claim::TYPE_PENEMUAN) {
            NotifikasiService::kirim(
                $claim->item->user,
                "Ada yang menemukan barang Anda ({$claim->item->kode})",
                "Ada yang menemukan barang Anda ({$claim->item->name}). Silakan temui petugas di lokasi penyimpanan dengan membawa bukti identitas.",
                route('items.show', $claim->item),
                'info'
            );
        }

        return redirect()
            ->route('verifikasi.claims.index')
            ->with('success', "Pengajuan {$claim->kode} berhasil diterima dan siap dilanjutkan ke proses serah terima.");
    }

    public function reject(Request $request, Claim $claim): RedirectResponse
    {
        $user = auth()->user();
        abort_if(!$user || (!$user->isAdmin() && !$user->isPetugas()), 403, 'Akses hanya untuk Admin dan Petugas.');

        // Hanya boleh bila status pengajuan masih diajukan
        if ($claim->status !== Claim::STATUS_DIAJUKAN) {
            return redirect()
                ->route('verifikasi.claims.index')
                ->with('error', "Pengajuan {$claim->kode} tidak dapat ditolak karena status saat ini: {$claim->statusLabel()}.");
        }

        $claim->update([
            'status' => Claim::STATUS_DITOLAK,
            'verifier_id' => $user->id,
            'verified_at' => now(),
        ]);

        // Notifikasi ke pengaju
        NotifikasiService::kirim(
            $claim->submitter,
            "Pengajuan {$claim->kode} ditolak",
            "Pengajuan {$claim->kode} Anda dinyatakan tidak sesuai/tidak valid dan telah ditolak oleh verifikator.",
            null,
            'danger'
        );

        return redirect()
            ->route('verifikasi.claims.index')
            ->with('success', "Pengajuan {$claim->kode} berhasil ditolak.");
    }
}

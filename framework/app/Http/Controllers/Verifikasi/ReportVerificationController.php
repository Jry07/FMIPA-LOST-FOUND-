<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Services\NotifikasiService;
use App\Services\StatusHistoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportVerificationController extends Controller
{
    public function index(Request $request): View
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses hanya diizinkan untuk Admin.');

        $reports = Item::with(['user', 'category'])
            ->where('status', Item::STATUS_MENUNGGU)
            ->orderBy('created_at', 'asc') // SRS: Terlama dulu
            ->paginate(10);

        return view('verifikasi.reports.index', compact('reports'));
    }

    public function show(Item $item): View
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses hanya diizinkan untuk Admin.');

        $item->load(['user', 'category', 'histories.user']);

        return view('verifikasi.reports.show', compact('item'));
    }

    public function approve(Request $request, Item $item): RedirectResponse
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses hanya diizinkan untuk Admin.');

        // Cegah double submit dan pastikan status masih menunggu
        if ($item->status !== Item::STATUS_MENUNGGU) {
            return redirect()
                ->route('verifikasi.reports.index')
                ->with('error', "Laporan {$item->kode} tidak dapat disetujui karena status saat ini: {$item->statusLabel()}.");
        }

        // Ubah status lewat StatusHistoryService (Aturan 7)
        StatusHistoryService::ubah(
            $item,
            Item::STATUS_DIPUBLIKASIKAN,
            auth()->user(),
            'Laporan disetujui dan dipublikasikan oleh admin.'
        );

        // Kirim notifikasi ke pelapor
        NotifikasiService::kirim(
            $item->user,
            "Laporan {$item->kode} dipublikasikan",
            "Laporan barang {$item->kode} ({$item->name}) telah disetujui dan kini dipublikasikan pada sistem.",
            route('items.show', $item),
            'success'
        );

        return redirect()
            ->route('verifikasi.reports.index')
            ->with('success', "Laporan {$item->kode} berhasil disetujui dan telah dipublikasikan.");
    }

    public function reject(Request $request, Item $item): RedirectResponse
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses hanya diizinkan untuk Admin.');

        // Cegah double submit dan pastikan status masih menunggu
        if ($item->status !== Item::STATUS_MENUNGGU) {
            return redirect()
                ->route('verifikasi.reports.index')
                ->with('error', "Laporan {$item->kode} tidak dapat ditolak karena status saat ini: {$item->statusLabel()}.");
        }

        // Ubah status lewat StatusHistoryService
        StatusHistoryService::ubah(
            $item,
            Item::STATUS_DITOLAK,
            auth()->user(),
            'Laporan ditolak oleh admin.'
        );

        // Kirim notifikasi ke pelapor
        NotifikasiService::kirim(
            $item->user,
            "Laporan {$item->kode} ditolak",
            "Laporan barang {$item->kode} ({$item->name}) dinyatakan tidak valid dan telah ditolak oleh admin.",
            null,
            'danger'
        );

        return redirect()
            ->route('verifikasi.reports.index')
            ->with('success', "Laporan {$item->kode} berhasil ditolak.");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard utama pengguna.
     */
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        // Status konstan
        $statusMenunggu = defined('App\Models\Item::STATUS_MENUNGGU')
            ? Item::STATUS_MENUNGGU
            : 'menunggu';
        $statusSelesai = defined('App\Models\Item::STATUS_SELESAI')
            ? Item::STATUS_SELESAI
            : 'selesai';
        $statusClaimDiajukan = defined('App\Models\Claim::STATUS_DIAJUKAN')
            ? Claim::STATUS_DIAJUKAN
            : 'diajukan';

        // 4 Kartu Statistik
        $totalLaporan = class_exists(Item::class)
            ? Item::where('user_id', $userId)->count()
            : 0;

        $laporanMenunggu = class_exists(Item::class)
            ? Item::where('user_id', $userId)->where('status', $statusMenunggu)->count()
            : 0;

        $totalKlaim = class_exists(Claim::class)
            ? Claim::where('user_id', $userId)->count()
            : 0;

        $klaimDiperiksa = class_exists(Claim::class)
            ? Claim::where('user_id', $userId)->where('status', $statusClaimDiajukan)->count()
            : 0;

        $laporanSelesai = class_exists(Item::class)
            ? Item::where('user_id', $userId)->where('status', $statusSelesai)->count()
            : 0;

        // Laporan Terbaru (1 laporan terakhir milik user)
        $laporanTerbaru = class_exists(Item::class)
            ? Item::where('user_id', $userId)
                ->with(['category'])
                ->latest()
                ->first()
            : null;

        // Notifikasi Terbaru (3 notifikasi terakhir)
        $notifikasiTerbaru = $user->notifications()
            ->latest()
            ->take(3)
            ->get();

        // Perkembangan Klaim Anda (1 klaim terbaru milik user)
        $klaimTerbaru = class_exists(Claim::class)
            ? Claim::where('user_id', $userId)
                ->with(['item.category'])
                ->latest()
                ->first()
            : null;

        // Riwayat Laporan (5 laporan terbaru)
        $riwayatLaporan = class_exists(Item::class)
            ? Item::where('user_id', $userId)
                ->with(['category'])
                ->latest()
                ->take(5)
                ->get()
            : collect();

        // Riwayat Klaim (5 klaim terbaru)
        $riwayatKlaim = class_exists(Claim::class)
            ? Claim::where('user_id', $userId)
                ->with(['item.category'])
                ->latest()
                ->take(5)
                ->get()
            : collect();

        return view('dashboard.index', compact(
            'totalLaporan',
            'laporanMenunggu',
            'totalKlaim',
            'klaimDiperiksa',
            'laporanSelesai',
            'laporanTerbaru',
            'notifikasiTerbaru',
            'klaimTerbaru',
            'riwayatLaporan',
            'riwayatKlaim'
        ));
    }
}

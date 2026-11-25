<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\HandoverRecord;
use App\Models\Item;
use App\Models\User;

// [M1-ADMIN]
class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik laporan per status
        $totalPerStatus = [
            'menunggu'       => Item::where('status', Item::STATUS_MENUNGGU)->count(),
            'dipublikasikan' => Item::where('status', Item::STATUS_DIPUBLIKASIKAN)->count(),
            'ditolak'        => Item::where('status', Item::STATUS_DITOLAK)->count(),
            'dibatalkan'     => Item::where('status', Item::STATUS_DIBATALKAN)->count(),
            'selesai'        => Item::where('status', Item::STATUS_SELESAI)->count(),
        ];
        $totalLaporan = array_sum($totalPerStatus);

        // Statistik laporan per tipe
        $totalLost  = Item::where('type', Item::TYPE_LOST)->count();
        $totalFound = Item::where('type', Item::TYPE_FOUND)->count();

        // Statistik klaim per status
        $totalKlaimPerStatus = [
            'diajukan' => Claim::where('status', Claim::STATUS_DIAJUKAN)->count(),
            'diterima' => Claim::where('status', Claim::STATUS_DITERIMA)->count(),
            'ditolak'  => Claim::where('status', Claim::STATUS_DITOLAK)->count(),
        ];

        // Serah terima selesai
        $totalHandover = HandoverRecord::count();

        // Akun per peran
        $totalPerRole = [
            'pengguna' => User::where('role', User::ROLE_PENGGUNA)->count(),
            'petugas'  => User::where('role', User::ROLE_PETUGAS)->count(),
            'admin'    => User::where('role', User::ROLE_ADMIN)->count(),
        ];
        $totalAkun = array_sum($totalPerRole);

        // Kartu aksi cepat
        $menungguVerifikasi  = $totalPerStatus['menunggu'];
        $menanggguVerifikasi = $menungguVerifikasi;
        $menungguPemeriksaan = $totalKlaimPerStatus['diajukan'];

        // Laporan terbaru (5 terakhir) + eager load
        $laporanTerbaru = Item::with(['user', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPerStatus',
            'totalLaporan',
            'totalLost',
            'totalFound',
            'totalKlaimPerStatus',
            'totalHandover',
            'totalPerRole',
            'totalAkun',
            'menungguVerifikasi',
            'menanggguVerifikasi',
            'menungguPemeriksaan',
            'laporanTerbaru'
        ));
    }
}
// [/M1-ADMIN]

<?php

namespace App\Http\Controllers\Klaim;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MyClaimController extends Controller
{
    /**
     * Tampilkan daftar seluruh pengajuan klaim dan penemuan milik pengguna saat ini.
     * Menggunakan pagination 10 dan eager loading untuk menghindari N+1.
     */
    public function index(Request $request): View
    {
        $claims = Claim::where('user_id', auth()->id())
            ->with(['item.category', 'verifier'])
            ->latest()
            ->paginate(10);

        return view('claims.my-index', compact('claims'));
    }

    /**
     * Tampilkan detail pengajuan klaim / penemuan milik pengguna.
     * Hak akses ketat: hanya pemilik pengajuan yang boleh melihat (NFR-04, NFR-05).
     */
    public function show(Claim $claim): View
    {
        // Otorisasi kepemilikan: tolak 403 jika bukan pemilik
        if ((int) $claim->user_id !== (int) auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat rincian pengajuan ini.');
        }

        // Eager load relasi terkait barang, verifikator, dan catatan serah terima
        $claim->loadMissing([
            'item.category',
            'item.user',
            'verifier',
            'item.handoverRecord.officer',
            'item.handoverRecord.receiver',
        ]);

        return view('claims.my-show', compact('claim'));
    }
}

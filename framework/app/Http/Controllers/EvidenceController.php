<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EvidenceController extends Controller
{
    /**
     * Menampilkan berkas bukti klaim privat (hanya pengaju klaim, admin, atau petugas).
     */
    public function show(Request $request, Claim $claim)
    {
        $user = $request->user();

        // Verifikasi hak akses: hanya pengaju klaim, admin, atau petugas
        if (! $user || (! $user->isAdmin() && ! $user->isPetugas() && $user->id !== $claim->user_id)) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki hak akses untuk melihat berkas bukti ini.');
        }

        if (! $claim->proof || ! Storage::disk('local')->exists($claim->proof)) {
            abort(404, 'Berkas bukti fisik tidak ditemukan di penyimpanan server.');
        }

        return Storage::disk('local')->response($claim->proof);
    }
}

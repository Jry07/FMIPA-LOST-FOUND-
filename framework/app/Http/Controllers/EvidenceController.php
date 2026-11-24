<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class EvidenceController extends Controller
{
    public function show(Claim $claim)
    {
        $user = auth()->user();

        // NFR-05: Bukti hanya boleh dilihat pengaju, admin, dan petugas
        if (!$user || (!$user->isAdmin() && !$user->isPetugas() && $claim->submitter_id !== $user->id)) {
            abort(403, 'Anda tidak berhak melihat bukti pengajuan ini.');
        }

        if (!$claim->evidence) {
            abort(404, 'Bukti tidak ditemukan.');
        }

        // Return file if exists in local disk or public disk
        if (Storage::disk('local')->exists($claim->evidence)) {
            return response()->file(Storage::disk('local')->path($claim->evidence));
        }

        if (Storage::disk('public')->exists($claim->evidence)) {
            return response()->file(Storage::disk('public')->path($claim->evidence));
        }

        // Fallback for public asset path
        $publicPath = public_path($claim->evidence);
        if (file_exists($publicPath)) {
            return response()->file($publicPath);
        }

        abort(404, 'Berkas bukti tidak ditemukan di penyimpanan server.');
    }
}

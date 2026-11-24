<?php

namespace App\Http\Controllers\Verification;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;

// [M6-VERIFIKASI]
class ClaimVerificationController extends Controller
{
    public function index()
    {
        return view('verification.claims.index');
    }

    public function show(Claim $claim)
    {
        return view('verification.claims.show', compact('claim'));
    }

    public function approve(Request $request, Claim $claim)
    {
        return redirect()->route('verification.claims.index')->with('info', 'Stub [M6-VERIFIKASI]: Penerimaan klaim/penemuan akan diimplementasikan pada modul M6.');
    }

    public function reject(Request $request, Claim $claim)
    {
        return redirect()->route('verification.claims.index')->with('info', 'Stub [M6-VERIFIKASI]: Penolakan klaim/penemuan akan diimplementasikan pada modul M6.');
    }
}
// [/M6-VERIFIKASI]

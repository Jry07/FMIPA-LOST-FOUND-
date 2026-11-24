<?php

namespace App\Http\Controllers\Verification;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

// [M6-VERIFIKASI]
class ItemVerificationController extends Controller
{
    public function index()
    {
        return view('verification.items.index');
    }

    public function show(Item $item)
    {
        return view('verification.items.show', compact('item'));
    }

    public function approve(Request $request, Item $item)
    {
        return redirect()->route('verification.items.index')->with('info', 'Stub [M6-VERIFIKASI]: Persetujuan laporan akan diimplementasikan pada modul M6.');
    }

    public function reject(Request $request, Item $item)
    {
        return redirect()->route('verification.items.index')->with('info', 'Stub [M6-VERIFIKASI]: Penolakan laporan akan diimplementasikan pada modul M6.');
    }
}
// [/M6-VERIFIKASI]

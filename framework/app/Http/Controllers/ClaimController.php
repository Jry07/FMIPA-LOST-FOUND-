<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Http\Request;

// [M5-KLAIM]
class ClaimController extends Controller
{
    public function createClaim(Item $item)
    {
        return view('claims.create-claim', compact('item'));
    }

    public function storeClaim(Request $request, Item $item)
    {
        return redirect()->route('thanks')->with('info', 'Stub [M5-KLAIM]: Pengajuan klaim akan diimplementasikan pada modul M5.');
    }

    public function createFound(Item $item)
    {
        return view('claims.create-found', compact('item'));
    }

    public function storeFound(Request $request, Item $item)
    {
        return redirect()->route('thanks')->with('info', 'Stub [M5-KLAIM]: Pelaporan penemuan barang akan diimplementasikan pada modul M5.');
    }

    public function myClaims()
    {
        return view('claims.my-claims');
    }

    public function show(Claim $claim)
    {
        return view('claims.show', compact('claim'));
    }
}
// [/M5-KLAIM]

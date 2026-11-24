<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

// [M3-LAPORAN]
class ItemController extends Controller
{
    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('items.my-reports')->with('info', 'Stub [M3-LAPORAN]: Penyimpanan laporan akan diimplementasikan pada modul M3.');
    }

    public function myReports()
    {
        return view('items.my-reports');
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        return redirect()->route('items.my-reports')->with('info', 'Stub [M3-LAPORAN]: Pembaruan laporan akan diimplementasikan pada modul M3.');
    }

    public function cancel(Request $request, Item $item)
    {
        return redirect()->route('items.my-reports')->with('info', 'Stub [M3-LAPORAN]: Pembatalan laporan akan diimplementasikan pada modul M3.');
    }
}
// [/M3-LAPORAN]

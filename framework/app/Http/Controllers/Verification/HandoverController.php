<?php

namespace App\Http\Controllers\Verification;

use App\Http\Controllers\Controller;
use App\Models\HandoverRecord;
use App\Models\Item;
use Illuminate\Http\Request;

// [M6-VERIFIKASI]
class HandoverController extends Controller
{
    public function index()
    {
        return view('verification.handover.index');
    }

    public function create(Item $item)
    {
        return view('verification.handover.create', compact('item'));
    }

    public function store(Request $request, Item $item)
    {
        return redirect()->route('verification.handover.index')->with('info', 'Stub [M6-VERIFIKASI]: Pencatatan serah terima akan diimplementasikan pada modul M6.');
    }

    public function show(HandoverRecord $handover)
    {
        return view('verification.handover.show', compact('handover'));
    }
}
// [/M6-VERIFIKASI]

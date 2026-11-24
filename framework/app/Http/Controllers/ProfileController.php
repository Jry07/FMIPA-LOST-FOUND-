<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// [M2-AUTH]
class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        return redirect()->route('profile.edit')->with('info', 'Stub [M2-AUTH]: Pembaruan profil akan diimplementasikan pada modul M2.');
    }

    public function updatePassword(Request $request)
    {
        return redirect()->route('profile.edit')->with('info', 'Stub [M2-AUTH]: Pembaruan kata sandi akan diimplementasikan pada modul M2.');
    }
}
// [/M2-AUTH]

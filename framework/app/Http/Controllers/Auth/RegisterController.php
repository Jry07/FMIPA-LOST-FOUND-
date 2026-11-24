<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// [M2-AUTH]
class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Stub logika registrasi akun modul M2
        return redirect()->route('login')->with('info', 'Stub [M2-AUTH]: Logika proses registrasi akan diimplementasikan pada modul M2.');
    }
}
// [/M2-AUTH]

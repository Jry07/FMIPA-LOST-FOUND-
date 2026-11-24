<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// [M2-AUTH]
class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Stub logika autentikasi modul M2
        return redirect()->route('home')->with('info', 'Stub [M2-AUTH]: Logika proses login akan diimplementasikan pada modul M2.');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Berhasil keluar dari sistem.');
    }
}
// [/M2-AUTH]

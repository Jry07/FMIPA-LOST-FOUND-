<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    /**
     * Tampilkan halaman Beranda (kondisi Tamu atau Pengguna Login).
     */
    public function home(): View
    {
        return view('pages.home');
    }

    /**
     * Tampilkan halaman Cara Kerja sistem.
     */
    public function caraKerja(): View
    {
        return view('pages.cara-kerja');
    }
}

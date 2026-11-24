@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/auth-landing.css') }}">
@endpush

@section('content')
<div class="m2-hero-wrapper">
    <div class="m2-container">
        @guest
            {{-- Keadaan Tamu (Sesuai Figma hal. 11) --}}
            <div class="m2-hero-grid">
                <div class="m2-hero-text">
                    <h1 class="m2-hero-title">Kehilangan atau Menemukan<br>Barang di Kampus?</h1>
                    <p class="m2-hero-desc">
                        FMIPA Lost & Found hadir sebagai pusat informasi barang hilang dan ditemukan di lingkungan Fakultas MIPA Universitas Halu Oleo.
                    </p>
                    <div class="m2-hero-actions">
                        <a href="{{ route('login') }}" class="m2-btn m2-btn-yellow">Masuk</a>
                        <a href="{{ route('register') }}" class="m2-btn m2-btn-cream">Daftar</a>
                    </div>
                </div>

                <div class="m2-badge-wrapper">
                    <div class="m2-circle-badge">
                        <div class="m2-badge-text-fmipa">fmipa</div>
                        <div class="m2-badge-text-lostfound">
                            <span>Lost</span>
                            <span class="m2-badge-ampersand">&amp;</span>
                            <span>Found</span>
                        </div>
                    </div>
                </div>
            </div>
        @endguest

        @auth
            {{-- Keadaan Pengguna Login (Sesuai Figma hal. 12) --}}
            <div class="m2-hero-centered">
                <h1 class="m2-hero-title">Selamat Datang, {{ auth()->user()->name }}!</h1>
                <p class="m2-hero-desc">
                    Laporkan barang hilang atau cek daftar temuan terbaru di lingkungan kampus FMIPA UHO dengan mudah.
                </p>
                <div class="m2-hero-actions">
                    <a href="{{ Route::has('items.index') ? route('items.index') : url('/barang') }}" class="m2-btn m2-btn-yellow">
                        Temukan Barang
                    </a>
                    <a href="{{ Route::has('reports.create') ? route('reports.create') : url('/lapor') }}" class="m2-btn m2-btn-cream">
                        Laporkan Barang
                    </a>
                </div>
            </div>
        @endauth
    </div>
</div>
@endsection

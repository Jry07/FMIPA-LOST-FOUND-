@extends('layouts.app')

@section('title', 'Cara Kerja')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/auth-landing.css') }}">
@endpush

@section('content')
<div class="m2-page-cara-kerja">
    <div class="m2-container">
        {{-- Header Cara Kerja --}}
        <div class="m2-ck-header">
            <h1 class="m2-ck-title">Cara Kerja</h1>
            <p class="m2-ck-subtitle">Dari laporan pertama hingga barang kembali ke tangan yang tepat.</p>
        </div>

        {{-- 4 Kartu Langkah Berurutan (Sesuai Figma hal. 5/6) --}}
        <div class="m2-ck-grid">
            {{-- Kartu 01 --}}
            <div class="m2-ck-card">
                <div class="m2-ck-card-top">
                    <div class="m2-ck-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    <span class="m2-ck-number">01</span>
                </div>
                <h3 class="m2-ck-card-title">Cari atau Laporkan Barang</h3>
                <p class="m2-ck-card-desc">
                    Telusuri daftar barang. Belum menemukannya? Buat laporan kehilangan atau penemuan.
                </p>
            </div>

            {{-- Kartu 02 --}}
            <div class="m2-ck-card">
                <div class="m2-ck-card-top">
                    <div class="m2-ck-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <rect x="9" y="13" width="6" height="5" rx="1"></rect>
                            <path d="M10 13v-2a2 2 0 1 1 4 0v2"></path>
                        </svg>
                    </div>
                    <span class="m2-ck-number">02</span>
                </div>
                <h3 class="m2-ck-card-title">Ajukan Klaim</h3>
                <p class="m2-ck-card-desc">
                    Merasa barang itu milik Anda? Sampaikan ciri khusus dan bukti melalui form privat.
                </p>
            </div>

            {{-- Kartu 03 --}}
            <div class="m2-ck-card">
                <div class="m2-ck-card-top">
                    <div class="m2-ck-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            <polyline points="9 12 11 14 15 10"></polyline>
                        </svg>
                    </div>
                    <span class="m2-ck-number">03</span>
                </div>
                <h3 class="m2-ck-card-title">Verifikasi Klaim</h3>
                <p class="m2-ck-card-desc">
                    Admin dan petugas berwenang memeriksa kecocokan informasi kepemilikan Anda.
                </p>
            </div>

            {{-- Kartu 04 --}}
            <div class="m2-ck-card">
                <div class="m2-ck-card-top">
                    <div class="m2-ck-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17"></path>
                            <path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.8a2 2 0 0 0-2.8-2.8l-3.2 3.2"></path>
                            <path d="M2 13a6 6 0 0 1 6-6h4"></path>
                        </svg>
                    </div>
                    <span class="m2-ck-number">04</span>
                </div>
                <h3 class="m2-ck-card-title">Serah Terima Barang</h3>
                <p class="m2-ck-card-desc">
                    Setelah disetujui, temui petugas. Serah terima dicatat agar barang kembali dengan aman.
                </p>
            </div>
        </div>

        {{-- Banner Bawah --}}
        <div class="m2-ck-banner">
            <div>
                <h2 class="m2-ck-banner-title">FMIPA Lost &amp; FOUND</h2>
                <p class="m2-ck-banner-desc">Temukan barang tanpa pemilik di kampus? Bantu seseorang menemukan kembali miliknya.</p>
            </div>
            <div>
                <a href="{{ Route::has('reports.create') ? route('reports.create') : url('/lapor') }}" class="m2-btn m2-btn-yellow">
                    Laporkan Barang &rarr;
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

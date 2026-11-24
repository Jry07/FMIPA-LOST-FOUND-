@extends('layouts.app')

@section('title', 'Beranda - FMIPA Lost & Found')

@section('content')
{{-- [M4-KATALOG] --}}
<div class="hero-section" style="text-align: center; padding: 48px 20px; background: #ffffff; border-radius: 16px; border: 1px solid var(--border); margin-bottom: 36px;">
    <span class="badge badge-type-lost" style="margin-bottom: 12px;">Sistem Informasi Kampus</span>
    <h1 style="font-size: 2.4rem; color: var(--maroon); margin-bottom: 16px;">
        Pusat Laporan Barang Hilang &amp; Ditemukan
    </h1>
    <p style="font-size: 1.1rem; color: var(--gray); max-width: 680px; margin: 0 auto 28px;">
        Fakultas Matematika dan Ilmu Pengetahuan Alam, Universitas Halu Oleo. Laporkan kehilangan atau temukan kembali barang Anda dengan mudah, aman, dan terverifikasi.
    </p>
    <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
        <a href="{{ route('catalog.index') }}" class="btn btn-yellow">🔍 Temukan Barang</a>
        @guest
            <a href="{{ route('register') }}" class="btn btn-maroon">Daftar Akun Baru</a>
            <a href="{{ route('login') }}" class="btn btn-cream">Masuk</a>
        @else
            <a href="{{ route('items.create') }}" class="btn btn-maroon">➕ Laporkan Barang</a>
        @endguest
    </div>
</div>

<x-page-header title="Barang Terbaru Dilaporkan" description="Daftar laporan barang hilang dan ditemukan di FMIPA UHO" />

<div class="catalog-grid">
    @php
        $latestItems = \App\Models\Item::where('status', \App\Models\Item::STATUS_DIPUBLIKASIKAN)->latest()->take(6)->get();
    @endphp
    @forelse($latestItems as $item)
        <x-item-card :item="$item" />
    @empty
        <x-empty-state title="Belum Ada Laporan" message="Belum ada laporan barang yang dipublikasikan saat ini." />
    @endforelse
</div>
{{-- [/M4-KATALOG] --}}
@endsection

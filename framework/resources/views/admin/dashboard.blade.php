@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - FMIPA Lost & Found')
@section('page_title', 'Dashboard Administrator')

@section('content')
{{-- [M1-ADMIN] --}}
<div class="stats-overview" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px;">
    <div style="background: #ffffff; padding: 20px; border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
        <span style="font-size: 0.85rem; color: var(--gray); font-weight: 600;">TOTAL LAPORAN</span>
        <h3 style="font-size: 2rem; color: var(--maroon); margin-top: 6px;">{{ \App\Models\Item::count() }}</h3>
    </div>
    <div style="background: #ffffff; padding: 20px; border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
        <span style="font-size: 0.85rem; color: var(--gray); font-weight: 600;">MENUNGGU VERIFIKASI</span>
        <h3 style="font-size: 2rem; color: var(--warning); margin-top: 6px;">{{ \App\Models\Item::where('status', \App\Models\Item::STATUS_MENUNGGU)->count() }}</h3>
    </div>
    <div style="background: #ffffff; padding: 20px; border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
        <span style="font-size: 0.85rem; color: var(--gray); font-weight: 600;">KLAIM DIAJUKAN</span>
        <h3 style="font-size: 2rem; color: var(--info); margin-top: 6px;">{{ \App\Models\Claim::where('status', \App\Models\Claim::STATUS_DIAJUKAN)->count() }}</h3>
    </div>
    <div style="background: #ffffff; padding: 20px; border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
        <span style="font-size: 0.85rem; color: var(--gray); font-weight: 600;">SERAH TERIMA SELESAI</span>
        <h3 style="font-size: 2rem; color: var(--success); margin-top: 6px;">{{ \App\Models\HandoverRecord::count() }}</h3>
    </div>
</div>

<x-page-header title="Aksi Cepat Admin">
    <a href="{{ route('verification.items.index') }}" class="btn btn-maroon">Periksa Laporan Baru</a>
</x-page-header>

<div style="background: #ffffff; padding: 24px; border-radius: 12px; border: 1px solid var(--border);">
    <p style="color: var(--gray);">
        Selamat datang di panel kontrol administrator FMIPA Lost &amp; Found. Gunakan menu sidebar untuk mengelola kategori master data, akun pengguna, moderasi laporan, dan rekap statistik.
    </p>
</div>
{{-- [/M1-ADMIN] --}}
@endsection

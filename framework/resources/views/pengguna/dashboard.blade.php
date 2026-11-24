@extends('layouts.dashboard')
@section('title', 'Dashboard Pengguna - FMIPA Lost & Found')
@section('page_title', 'Beranda Pengguna')
@section('content')
{{-- [M4-KATALOG] --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:28px;">
    @php
        $uid = Auth::id();
        $myItems = \App\Models\Item::where('user_id',$uid)->count();
        $myClaims = \App\Models\Claim::where('user_id',$uid)->count();
    @endphp
    <div style="background:#fff;padding:20px;border-radius:12px;border:1px solid var(--border);">
        <span style="font-size:0.8rem;color:var(--gray);font-weight:600;">LAPORAN SAYA</span>
        <h3 style="font-size:2rem;color:var(--maroon);margin-top:6px;">{{ $myItems }}</h3>
        <a href="{{ route('items.my-reports') }}" style="font-size:0.85rem;color:var(--maroon);font-weight:600;">Lihat Semua →</a>
    </div>
    <div style="background:#fff;padding:20px;border-radius:12px;border:1px solid var(--border);">
        <span style="font-size:0.8rem;color:var(--gray);font-weight:600;">KLAIM SAYA</span>
        <h3 style="font-size:2rem;color:var(--info);margin-top:6px;">{{ $myClaims }}</h3>
        <a href="{{ route('claims.my-claims') }}" style="font-size:0.85rem;color:var(--maroon);font-weight:600;">Lihat Semua →</a>
    </div>
    <div style="background:var(--maroon);padding:20px;border-radius:12px;color:#fff;">
        <span style="font-size:0.8rem;opacity:0.8;font-weight:600;">BUAT LAPORAN BARU</span>
        <p style="font-size:0.9rem;margin:8px 0 14px;opacity:0.85;">Laporkan barang hilang atau temuan Anda.</p>
        <a href="{{ route('items.create') }}" class="btn-sm" style="background:var(--yellow);color:var(--dark);border-radius:6px;padding:7px 14px;font-weight:600;">➕ Laporkan Barang</a>
    </div>
</div>

<x-page-header title="Barang Terbaru Dipublikasikan" />
<div class="catalog-grid">
    @php $items = \App\Models\Item::where('status',\App\Models\Item::STATUS_DIPUBLIKASIKAN)->latest()->take(6)->get(); @endphp
    @forelse($items as $item)
        <x-item-card :item="$item" />
    @empty
        <x-empty-state title="Belum Ada Barang" message="Belum ada laporan barang yang dipublikasikan." />
    @endforelse
</div>
{{-- [/M4-KATALOG] --}}
@endsection

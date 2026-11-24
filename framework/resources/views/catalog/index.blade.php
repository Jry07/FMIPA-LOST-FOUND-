@extends('layouts.app')
@section('title', 'Katalog Barang - FMIPA Lost & Found')
@section('content')
{{-- [M4-KATALOG] --}}
<x-page-header title="Katalog Barang" description="Temukan laporan barang hilang dan ditemukan di FMIPA UHO (9 laporan per halaman)" />

{{-- Filter & Search (Stub - M4 implementasi logika) --}}
<div style="background:#fff;padding:20px;border-radius:12px;border:1px solid var(--border);margin-bottom:24px;">
    <form method="GET" action="{{ route('catalog.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <div style="flex:2;min-width:200px;">
            <label class="form-label">Cari Barang</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama barang, ciri, lokasi..." class="form-control">
        </div>
        <div style="min-width:160px;">
            <label class="form-label">Tipe</label>
            <select name="type" class="form-select">
                <option value="">Semua Tipe</option>
                <option value="lost" {{ request('type')=='lost'?'selected':'' }}>Barang Hilang</option>
                <option value="found" {{ request('type')=='found'?'selected':'' }}>Barang Ditemukan</option>
            </select>
        </div>
        <div style="min-width:160px;">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach(\App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div style="min-width:140px;">
            <label class="form-label">Tanggal</label>
            <input type="date" name="date" value="{{ request('date') }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-maroon">🔍 Filter</button>
        <a href="{{ route('catalog.index') }}" class="btn btn-outline">Reset</a>
    </form>
</div>

@php
    $items = \App\Models\Item::where('status', \App\Models\Item::STATUS_DIPUBLIKASIKAN)
        ->with(['category'])
        ->when(request('q'), fn($q,$s)=>$q->where('name','like',"%$s%")->orWhere('description','like',"%$s%"))
        ->when(request('type'), fn($q,$t)=>$q->where('type',$t))
        ->when(request('category_id'), fn($q,$c)=>$q->where('category_id',$c))
        ->when(request('date'), fn($q,$d)=>$q->whereDate('incident_date',$d))
        ->latest()
        ->paginate(9);
@endphp

<div class="catalog-grid">
    @forelse($items as $item)
        <x-item-card :item="$item" />
    @empty
        <x-empty-state
            title="Tidak Ada Hasil"
            message="Tidak ada barang yang cocok dengan filter pencarian Anda."
            icon="🔍"
            actionText="Reset Filter"
            actionUrl="{{ route('catalog.index') }}"
        />
    @endforelse
</div>

<div style="margin-top:24px;display:flex;justify-content:center;">
    {{ $items->links() }}
</div>
{{-- [/M4-KATALOG] --}}
@endsection

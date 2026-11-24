@extends('layouts.dashboard')
@section('title', 'Laporan Saya - FMIPA Lost & Found')
@section('page_title', 'Laporan Barang Saya')
@section('content')
{{-- [M3-LAPORAN] --}}
<x-page-header title="Laporan Saya" description="Daftar semua laporan barang yang pernah Anda buat">
    <a href="{{ route('items.create') }}" class="btn btn-yellow">➕ Buat Laporan Baru</a>
</x-page-header>

@php $myItems = \App\Models\Item::where('user_id', Auth::id())->with('category')->latest()->get(); @endphp

@if($myItems->isEmpty())
    <x-empty-state title="Belum Ada Laporan" message="Anda belum pernah membuat laporan barang hilang atau ditemukan."
        icon="📋" actionText="Buat Laporan Pertama" actionUrl="{{ route('items.create') }}" />
@else
<div class="table-responsive">
    <table class="table-custom">
        <thead>
            <tr><th>Kode</th><th>Nama Barang</th><th>Tipe</th><th>Kategori</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($myItems as $item)
            <tr>
                <td><code>{{ $item->kode }}</code></td>
                <td><strong>{{ $item->name }}</strong></td>
                <td><x-type-badge :type="$item->type" /></td>
                <td>{{ $item->category->name ?? '-' }}</td>
                <td>{{ $item->incident_date->format('d M Y') }}</td>
                <td><x-status-badge :status="$item->status" /></td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('catalog.show', $item) }}" class="btn-sm btn-cream">Lihat</a>
                        @if($item->status === \App\Models\Item::STATUS_MENUNGGU)
                        <a href="{{ route('items.edit', $item) }}" class="btn-sm btn-yellow">Edit</a>
                        <form action="{{ route('items.cancel', $item) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-sm btn-maroon"
                                data-confirm="Yakin ingin membatalkan laporan ini?">Batalkan</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
{{-- [/M3-LAPORAN] --}}
@endsection

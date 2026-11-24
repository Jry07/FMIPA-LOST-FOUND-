@extends('layouts.dashboard')
@section('title', 'Laporkan Penemuan - FMIPA Lost & Found')
@section('page_title', 'Saya Menemukan Barang Ini')
@section('content')
{{-- [M5-KLAIM] --}}
<x-page-header title="Laporkan Penemuan Barang" description="Isi formulir berikut untuk melaporkan bahwa Anda menemukan barang ini" />

<div style="display:grid;grid-template-columns:1fr 1.3fr;gap:24px;align-items:start;">
    <div style="background:#fff;padding:20px;border-radius:12px;border:1px solid var(--border);">
        <h3 style="margin-bottom:14px;font-size:1rem;">Barang yang Ditemukan</h3>
        <div style="display:flex;gap:8px;margin-bottom:12px;flex-wrap:wrap;">
            <x-type-badge :type="$item->type" />
            <x-status-badge :status="$item->status" />
        </div>
        <h4>{{ $item->name }}</h4>
        <p style="color:var(--gray);font-size:0.88rem;margin-top:6px;">📍 {{ $item->location }}</p>
        <code style="font-size:0.8rem;color:var(--gray);">{{ $item->kode }}</code>
    </div>

    <div style="background:#fff;padding:24px;border-radius:12px;border:1px solid var(--border);">
        <form action="{{ route('claims.store-found', $item) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-form.input label="Lokasi Saat Ditemukan" name="found_location" required placeholder="Misal: Parkiran Gedung B FMIPA" />
            <x-form.input label="Waktu Ditemukan" name="found_time" type="datetime-local" required />
            <x-form.input label="Lokasi Penitipan Barang Saat Ini" name="storage_location" required
                placeholder="Misal: Pos Satpam FMIPA / dipegang penemu" />
            <x-form.textarea label="Keterangan Tambahan" name="description" rows="3"
                placeholder="Kondisi barang saat ditemukan, apakah ada kerusakan, dsb." />
            <x-form.file label="Foto Bukti Penemuan (Opsional)" name="proof" accept="image/*"
                helpText="Foto barang saat pertama ditemukan. Maks. 2 MB. Bersifat privat." />
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="submit" class="btn btn-yellow">Laporkan Penemuan</button>
                <a href="{{ route('catalog.show',$item) }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
{{-- [/M5-KLAIM] --}}
@endsection

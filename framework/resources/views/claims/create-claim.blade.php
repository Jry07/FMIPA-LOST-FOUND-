@extends('layouts.dashboard')
@section('title', 'Ajukan Klaim - FMIPA Lost & Found')
@section('page_title', 'Ajukan Klaim Kepemilikan')
@section('content')
{{-- [M5-KLAIM] --}}
<x-page-header title="Ajukan Klaim Kepemilikan" description="Ajukan klaim bahwa barang Found berikut adalah milik Anda" />

@include('claims.partials.info-steps')

<div style="display:grid;grid-template-columns:1fr 1.3fr;gap:24px;align-items:start;">
    {{-- Info Barang --}}
    <div style="background:#fff;padding:20px;border-radius:12px;border:1px solid var(--border);">
        <h3 style="margin-bottom:14px;font-size:1rem;">Barang yang Diklaim</h3>
        <div style="display:flex;gap:12px;margin-bottom:12px;">
            <x-type-badge :type="$item->type" />
            <x-status-badge :status="$item->status" />
        </div>
        <h4>{{ $item->name }}</h4>
        <p style="color:var(--gray);font-size:0.88rem;margin-top:6px;">📍 {{ $item->location }}</p>
        <p style="color:var(--gray);font-size:0.88rem;">📅 {{ $item->incident_date?->format('d F Y') }}</p>
        <code style="font-size:0.8rem;color:var(--gray);">{{ $item->kode }}</code>
    </div>

    {{-- Form Klaim --}}
    <div style="background:#fff;padding:24px;border-radius:12px;border:1px solid var(--border);">
        <form action="{{ route('claims.store-claim', $item) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-form.textarea label="Deskripsi Kepemilikan" name="description" required rows="4"
                placeholder="Jelaskan ciri unik yang hanya pemilik sah yang tahu (nomor seri, isi dompet, tanda khusus, dsb.)" />
            <x-form.file label="Unggah Bukti Kepemilikan" name="proof" accept="image/*,application/pdf"
                helpText="Foto nota pembelian, kartu garansi, atau foto lain. Maks. 2 MB. Bersifat PRIVAT." />
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="submit" class="btn btn-yellow">Kirim Klaim</button>
                <a href="{{ route('catalog.show',$item) }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
{{-- [/M5-KLAIM] --}}
@endsection

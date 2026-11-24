@extends('layouts.app')
@section('title', ($item->name ?? 'Detail Barang') . ' - FMIPA Lost & Found')
@section('content')
{{-- [M4-KATALOG] --}}
<div style="margin-bottom:16px;">
    <a href="{{ route('catalog.index') }}" style="color:var(--gray);font-size:0.9rem;">← Kembali ke Katalog</a>
</div>

<div style="display:grid;grid-template-columns:1fr 1.5fr;gap:28px;align-items:start;">
    {{-- Foto Barang --}}
    <div>
        <div style="border-radius:12px;overflow:hidden;border:1px solid var(--border);">
            @if($item->photo)
                <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->name }}" style="width:100%;object-fit:cover;">
            @else
                <img src="{{ asset('storage/items/placeholder.svg') }}" alt="Placeholder" style="width:100%;object-fit:cover;">
            @endif
        </div>
        <div style="display:flex;gap:8px;margin-top:12px;flex-wrap:wrap;">
            <x-type-badge :type="$item->type" />
            <x-status-badge :status="$item->status" />
        </div>
    </div>

    {{-- Informasi Detail --}}
    <div>
        <div style="background:#fff;padding:24px;border-radius:12px;border:1px solid var(--border);">
            <span style="font-size:0.8rem;color:var(--maroon);font-weight:700;text-transform:uppercase;">{{ $item->category->name ?? 'Kategori' }}</span>
            <h1 style="font-size:1.6rem;margin:8px 0;">{{ $item->name }}</h1>
            <span style="font-family:monospace;color:var(--gray);font-size:0.9rem;">{{ $item->kode }}</span>

            <div style="margin:20px 0;padding:16px;background:var(--cream-light);border-radius:8px;border:1px solid var(--border);">
                <h3 style="font-size:1rem;margin-bottom:12px;">Informasi Laporan</h3>
                <div style="display:grid;gap:10px;font-size:0.9rem;">
                    <div style="display:flex;gap:8px;"><span style="font-weight:600;min-width:120px;">📍 Lokasi:</span><span>{{ $item->location }}</span></div>
                    <div style="display:flex;gap:8px;"><span style="font-weight:600;min-width:120px;">📅 Tanggal:</span><span>{{ $item->incident_date?->format('d F Y') }}</span></div>
                    @if($item->incident_time)
                    <div style="display:flex;gap:8px;"><span style="font-weight:600;min-width:120px;">🕐 Pukul:</span><span>{{ $item->incident_time }}</span></div>
                    @endif
                    <div style="display:flex;gap:8px;"><span style="font-weight:600;min-width:120px;">👤 Pelapor:</span><span>{{ $item->user->name ?? 'Anonim' }}</span></div>
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <h3 style="font-size:1rem;margin-bottom:8px;">Ciri-Ciri Barang</h3>
                <p style="color:var(--gray);line-height:1.7;">{{ $item->description }}</p>
            </div>

            {{-- Tombol aksi klaim / penemuan (stub, akan diisi M5) --}}
            @include('claims.partials.action-button', compact('item'))

            @guest
            <div style="padding:16px;background:var(--cream);border-radius:8px;text-align:center;">
                <p style="margin-bottom:12px;font-size:0.9rem;color:var(--dark);">Masuk ke akun untuk mengajukan klaim atau melaporkan penemuan.</p>
                <a href="{{ route('login') }}" class="btn btn-maroon">Masuk ke Akun</a>
            </div>
            @endguest
        </div>
    </div>
</div>
{{-- [/M4-KATALOG] --}}
@endsection

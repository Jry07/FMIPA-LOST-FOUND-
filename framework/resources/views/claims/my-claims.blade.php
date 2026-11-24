@extends('layouts.dashboard')
@section('title', 'Klaim Saya - FMIPA Lost & Found')
@section('page_title', 'Klaim & Penemuan Saya')
@section('content')
{{-- [M5-KLAIM] --}}
<x-page-header title="Klaim &amp; Penemuan Saya" description="Pantau status pengajuan klaim kepemilikan dan pelaporan penemuan barang" />

@php $myClaims = \App\Models\Claim::where('user_id', Auth::id())->with(['item'])->latest()->get(); @endphp

@if($myClaims->isEmpty())
    <x-empty-state title="Belum Ada Klaim" message="Anda belum mengajukan klaim kepemilikan atau pelaporan penemuan."
        icon="🤝" actionText="Jelajahi Barang Temuan" actionUrl="{{ route('catalog.index') }}" />
@else
<div class="table-responsive">
    <table class="table-custom">
        <thead>
            <tr><th>Kode</th><th>Barang</th><th>Jenis</th><th>Diajukan</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($myClaims as $klaim)
            <tr>
                <td><code>{{ $klaim->kode }}</code></td>
                <td>
                    <strong>{{ $klaim->item->name ?? '-' }}</strong><br>
                    <small style="color:var(--gray);">{{ $klaim->item->kode ?? '-' }}</small>
                </td>
                <td><x-type-badge :type="$klaim->type" /></td>
                <td>{{ $klaim->created_at->format('d M Y') }}</td>
                <td><x-status-badge :status="$klaim->status" /></td>
                <td>
                    <a href="{{ route('claims.show', $klaim) }}" class="btn-sm btn-cream">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
{{-- [/M5-KLAIM] --}}
@endsection

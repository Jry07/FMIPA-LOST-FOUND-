{{-- [M6-VERIFIKASI] --}}
@extends('layouts.dashboard')

@section('title', 'Serah Terima Barang')

@section('content')
<x-page-header
    title="Serah Terima Barang"
    subtitle="Daftar berita acara serah terima barang kepada pemilik"
/>

<x-alert />

<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('verification.handover.create') }}" class="btn btn-maroon">
        + Catat Serah Terima
    </a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Serah Terima</h5>
        <span class="badge bg-warning text-dark">Stub — Implementasi oleh M6</span>
    </div>
    <div class="card-body">
        <x-empty-state
            icon="🤝"
            title="Belum Ada Serah Terima"
            description="Belum ada catatan serah terima barang."
        />
        {{--
            TODO [M6-VERIFIKASI]:
            - Tampilkan daftar handover_records
            - Kolom: item, penerima, petugas, tanggal, bukti, aksi
            - Filter berdasarkan tanggal
        --}}
    </div>
</div>
{{-- [/M6-VERIFIKASI] --}}
@endsection

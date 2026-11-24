{{-- [M6-VERIFIKASI] --}}
@extends('layouts.dashboard')

@section('title', 'Verifikasi Laporan')

@section('content')
<x-page-header
    title="Verifikasi Laporan"
    subtitle="Daftar laporan barang yang menunggu verifikasi admin/petugas"
/>

<x-alert />

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Laporan Menunggu Verifikasi</h5>
        <span class="badge bg-warning text-dark">Stub — Implementasi oleh M6</span>
    </div>
    <div class="card-body">
        <x-empty-state
            icon="📋"
            title="Belum Ada Laporan"
            description="Belum ada laporan yang perlu diverifikasi saat ini."
        />
        {{--
            TODO [M6-VERIFIKASI]:
            - Tampilkan daftar item dengan status 'menunggu' atau 'diproses'
            - Filter berdasarkan type (hilang/ditemukan)
            - Tombol aksi: Setujui, Tolak
        --}}
    </div>
</div>
{{-- [/M6-VERIFIKASI] --}}
@endsection

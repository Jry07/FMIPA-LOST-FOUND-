{{-- [M6-VERIFIKASI] --}}
@extends('layouts.dashboard')

@section('title', 'Verifikasi Klaim')

@section('content')
<x-page-header
    title="Verifikasi Klaim"
    subtitle="Daftar klaim dan penemuan yang menunggu tindakan"
/>

<x-alert />

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Klaim Diajukan</h5>
        <span class="badge bg-warning text-dark">Stub — Implementasi oleh M6</span>
    </div>
    <div class="card-body">
        <x-empty-state
            icon="📝"
            title="Belum Ada Klaim"
            description="Belum ada klaim yang perlu ditindaklanjuti saat ini."
        />
        {{--
            TODO [M6-VERIFIKASI]:
            - Tampilkan daftar claims dengan status 'diajukan'
            - Filter berdasarkan type klaim (klaim/penemuan)
            - Kolom: kode, pengaju, barang, tanggal, status, aksi
            - Link ke verification.claims.show
        --}}
    </div>
</div>
{{-- [/M6-VERIFIKASI] --}}
@endsection

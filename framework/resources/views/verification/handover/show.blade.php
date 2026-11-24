{{-- [M6-VERIFIKASI] --}}
@extends('layouts.dashboard')

@section('title', 'Detail Serah Terima')

@section('content')
<x-page-header
    title="Berita Acara Serah Terima"
    subtitle="Detail pencatatan serah terima barang"
    :breadcrumbs="[
        ['label' => 'Serah Terima', 'url' => route('verification.handover.index')],
        ['label' => 'Detail']
    ]"
/>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Detail Berita Acara</h5>
            </div>
            <div class="card-body">
                {{--
                    TODO [M6-VERIFIKASI]:
                    - Tampilkan: nama penerima, NIM, petugas pencatat, tanggal
                    - Link download/lihat foto berita acara (dari disk privat)
                    - Catatan
                --}}
                <x-empty-state
                    icon="📋"
                    title="Stub Detail Serah Terima"
                    description="Implementasi detail berita acara oleh modul M6."
                />
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Barang</h5>
            </div>
            <div class="card-body">
                {{-- TODO [M6-VERIFIKASI]: item card --}}
                <p class="text-muted">Info barang akan ditampilkan di sini.</p>
            </div>
        </div>
    </div>
</div>
{{-- [/M6-VERIFIKASI] --}}
@endsection

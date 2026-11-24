{{-- [M6-VERIFIKASI] --}}
@extends('layouts.dashboard')

@section('title', 'Detail Verifikasi Laporan')

@section('content')
<x-page-header
    title="Detail Laporan {{ $item->kode ?? '' }}"
    subtitle="Verifikasi laporan barang hilang/ditemukan"
    :breadcrumbs="[
        ['label' => 'Verifikasi Laporan', 'url' => route('verification.items.index')],
        ['label' => 'Detail']
    ]"
/>

<x-alert />

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Laporan</h5>
            </div>
            <div class="card-body">
                {{--
                    TODO [M6-VERIFIKASI]:
                    - Tampilkan detail item (foto, nama, deskripsi, lokasi, tanggal)
                    - Form perubahan status (setujui/tolak/proses)
                    - Gunakan StatusHistoryService::ubah()
                --}}
                <x-empty-state
                    icon="🔍"
                    title="Stub Verifikasi Laporan"
                    description="Implementasi detail verifikasi laporan oleh modul M6."
                />
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Status</h5>
            </div>
            <div class="card-body">
                {{-- TODO [M6-VERIFIKASI]: tampilkan item_status_histories --}}
                <p class="text-muted">Riwayat status akan ditampilkan di sini.</p>
            </div>
        </div>
    </div>
</div>
{{-- [/M6-VERIFIKASI] --}}
@endsection

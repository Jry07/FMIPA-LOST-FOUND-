{{-- [M6-VERIFIKASI] --}}
@extends('layouts.dashboard')

@section('title', 'Detail Verifikasi Klaim')

@section('content')
<x-page-header
    title="Detail Klaim"
    subtitle="Verifikasi pengajuan klaim barang"
    :breadcrumbs="[
        ['label' => 'Verifikasi Klaim', 'url' => route('verification.claims.index')],
        ['label' => 'Detail']
    ]"
/>

<x-alert />

<div class="row">
    <div class="col-md-7">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Informasi Klaim</h5>
            </div>
            <div class="card-body">
                {{--
                    TODO [M6-VERIFIKASI]:
                    - Tampilkan detail klaim (pengaju, deskripsi, bukti)
                    - Link ke claims.evidence untuk lihat bukti privat
                    - Form approve/reject dengan catatan
                    - Gunakan StatusHistoryService::ubah()
                    - Gunakan NotifikasiService::kirim() setelah update
                --}}
                <x-empty-state
                    icon="🔎"
                    title="Stub Verifikasi Klaim"
                    description="Implementasi detail verifikasi klaim oleh modul M6."
                />
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Barang Terkait</h5>
            </div>
            <div class="card-body">
                {{-- TODO [M6-VERIFIKASI]: tampilkan item card --}}
                <p class="text-muted">Info barang akan ditampilkan di sini.</p>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Klaim</h5>
            </div>
            <div class="card-body">
                {{-- TODO [M6-VERIFIKASI]: riwayat perubahan status klaim --}}
                <p class="text-muted">Riwayat status akan ditampilkan di sini.</p>
            </div>
        </div>
    </div>
</div>
{{-- [/M6-VERIFIKASI] --}}
@endsection

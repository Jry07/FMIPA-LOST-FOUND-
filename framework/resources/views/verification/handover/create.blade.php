{{-- [M6-VERIFIKASI] --}}
@extends('layouts.dashboard')

@section('title', 'Catat Serah Terima')

@section('content')
<x-page-header
    title="Catat Serah Terima"
    subtitle="Formulir pencatatan berita acara serah terima barang kepada pemilik"
    :breadcrumbs="[
        ['label' => 'Serah Terima', 'url' => route('verification.handover.index')],
        ['label' => 'Catat Baru']
    ]"
/>

<x-alert />

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Formulir Serah Terima</h5>
    </div>
    <div class="card-body">
        {{--
            TODO [M6-VERIFIKASI]:
            - Pilih item yang statusnya 'disetujui'
            - Input: nama penerima, NIM penerima, identitas yang diverifikasi
            - Upload foto berita acara (FileUploadService::simpanPrivat())
            - Catatan tambahan
            - Setelah simpan: update item status ke 'selesai' via StatusHistoryService::ubah()
            - Buat handover_record (item_id UNIK)
            - Kirim notifikasi via NotifikasiService::kirim()
        --}}
        <x-empty-state
            icon="📄"
            title="Stub Form Serah Terima"
            description="Implementasi form serah terima oleh modul M6."
        />
        <div class="text-center mt-3">
            <a href="{{ route('verification.handover.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </div>
</div>
{{-- [/M6-VERIFIKASI] --}}
@endsection

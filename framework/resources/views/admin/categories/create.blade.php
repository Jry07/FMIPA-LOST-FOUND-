{{-- [M1-ADMIN] --}}
@extends('layouts.dashboard')

@section('title', 'Tambah Kategori')
@section('page_title', 'Tambah Kategori')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/admin.css') }}">
@endpush

@section('content')

<x-page-header
    title="Tambah Kategori Baru"
    subtitle="Buat kategori baru untuk mengelompokkan laporan barang"
/>

<div class="form-card">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <x-form.input
            name="name"
            label="Nama Kategori"
            placeholder="contoh: Elektronik, Tas dan Dompet, Kunci..."
            :required="true"
            maxlength="60"
        />

        <x-form.textarea
            name="description"
            label="Deskripsi"
            placeholder="Deskripsi singkat kategori ini (opsional)..."
            rows="3"
            maxlength="255"
        />

        <div class="form-actions">
            <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
                ← Batal
            </a>
            <button type="submit" class="btn-maroon">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>

{{-- [/M1-ADMIN] --}}
@endsection

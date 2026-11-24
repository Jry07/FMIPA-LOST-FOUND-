{{-- [M1-ADMIN] --}}
@extends('layouts.dashboard')

@section('title', 'Ubah Kategori')
@section('page_title', 'Ubah Kategori')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/admin.css') }}">
@endpush

@section('content')

<x-page-header
    title="Ubah Kategori: {{ $category->name }}"
    subtitle="Perbarui informasi kategori barang"
/>

<div class="form-card">
    @if($category->items_count > 0)
        <div class="alert-info-box">
            ℹ️ Kategori ini dipakai oleh <strong>{{ $category->items_count }} laporan</strong>.
            Nama dapat diubah, tetapi kategori tidak dapat dihapus selama masih digunakan.
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <x-form.input
            name="name"
            label="Nama Kategori"
            placeholder="contoh: Elektronik, Tas dan Dompet, Kunci..."
            :required="true"
            maxlength="60"
            :value="old('name', $category->name)"
        />

        <x-form.textarea
            name="description"
            label="Deskripsi"
            placeholder="Deskripsi singkat kategori ini (opsional)..."
            rows="3"
            maxlength="255"
            :value="old('description', $category->description)"
        />

        <div class="form-actions">
            <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
                ← Batal
            </a>
            <button type="submit" class="btn-maroon">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

{{-- [/M1-ADMIN] --}}
@endsection

@extends('layouts.dashboard')

@section('title', 'Tambah Kategori - Admin')
@section('page_title', 'Tambah Kategori Baru')

@section('content')
{{-- [M1-ADMIN] --}}
<x-page-header title="Form Tambah Kategori" description="Masukkan nama kategori barang baru" />

<div style="background: #ffffff; padding: 24px; border-radius: 12px; border: 1px solid var(--border); max-width: 600px;">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <x-form.input label="Nama Kategori" name="name" placeholder="Misal: Perangkat Musik" required />
        <x-form.textarea label="Deskripsi Kategori" name="description" placeholder="Penjelasan barang yang masuk ke kategori ini..." />
        
        <div style="display: flex; gap: 12px; margin-top: 20px;">
            <button type="submit" class="btn btn-yellow">Simpan Kategori</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
{{-- [/M1-ADMIN] --}}
@endsection

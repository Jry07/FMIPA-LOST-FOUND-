@extends('layouts.dashboard')

@section('title', 'Edit Kategori - Admin')
@section('page_title', 'Ubah Kategori Barang')

@section('content')
{{-- [M1-ADMIN] --}}
<x-page-header title="Edit Kategori" description="Ubah informasi kategori barang" />

<div style="background: #ffffff; padding: 24px; border-radius: 12px; border: 1px solid var(--border); max-width: 600px;">
    <form action="{{ route('admin.categories.update', $id ?? 1) }}" method="POST">
        @csrf
        @method('PUT')
        <x-form.input label="Nama Kategori" name="name" value="Kategori Contoh" required />
        <x-form.textarea label="Deskripsi Kategori" name="description" value="Deskripsi contoh kategori..." />
        
        <div style="display: flex; gap: 12px; margin-top: 20px;">
            <button type="submit" class="btn btn-yellow">Perbarui Kategori</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
{{-- [/M1-ADMIN] --}}
@endsection

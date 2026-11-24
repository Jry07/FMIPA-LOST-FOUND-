@extends('layouts.dashboard')
@section('title', 'Edit Laporan - FMIPA Lost & Found')
@section('page_title', 'Edit Laporan Barang')
@section('content')
{{-- [M3-LAPORAN] --}}
<x-page-header title="Edit Laporan" description="Hanya laporan berstatus 'Menunggu Verifikasi' yang dapat diubah" />

<div style="background:#fff;padding:28px;border-radius:12px;border:1px solid var(--border);max-width:700px;">
    <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div style="grid-column:span 2;">
                <x-form.input label="Nama Barang" name="name" :value="$item->name" required />
            </div>
            <x-form.select label="Kategori" name="category_id" required
                :options="\App\Models\Category::pluck('name','id')->toArray()"
                :selected="$item->category_id" />
            <x-form.input label="Lokasi Kejadian" name="location" :value="$item->location" required />
            <x-form.input label="Tanggal Kejadian" name="incident_date" type="date" :value="$item->incident_date?->format('Y-m-d')" required />
            <x-form.input label="Perkiraan Waktu" name="incident_time" type="time" :value="$item->incident_time" />
            <div style="grid-column:span 2;">
                <x-form.textarea label="Ciri-Ciri Spesifik" name="description" :value="$item->description" required rows="4" />
            </div>
            <div style="grid-column:span 2;">
                <x-form.file label="Ganti Foto Barang (Opsional)" name="photo" />
            </div>
        </div>
        <div style="display:flex;gap:12px;margin-top:20px;padding-top:20px;border-top:1px solid var(--border);">
            <button type="submit" class="btn btn-yellow">Simpan Perubahan</button>
            <a href="{{ route('items.my-reports') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
{{-- [/M3-LAPORAN] --}}
@endsection

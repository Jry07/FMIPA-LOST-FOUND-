@extends('layouts.dashboard')
@section('title', 'Laporkan Barang - FMIPA Lost & Found')
@section('page_title', 'Laporkan Barang')
@section('content')
{{-- [M3-LAPORAN] --}}
<x-page-header title="Buat Laporan Barang" description="Laporkan barang hilang (Lost) atau barang yang Anda temukan (Found)" />

<div style="background:#fff;padding:28px;border-radius:12px;border:1px solid var(--border);max-width:700px;">
    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div style="grid-column:span 2;">
                <x-form.select
                    label="Tipe Laporan"
                    name="type"
                    required
                    :options="['lost'=>'Barang Hilang (Lost)','found'=>'Barang Ditemukan (Found)']"
                />
            </div>
            <div style="grid-column:span 2;">
                <x-form.input label="Nama Barang" name="name" placeholder="Misal: Laptop Lenovo ThinkPad Hitam" required />
            </div>
            <x-form.select
                label="Kategori"
                name="category_id"
                required
                :options="\App\Models\Category::pluck('name','id')->toArray()"
            />
            <x-form.input label="Lokasi Kejadian" name="location" placeholder="Misal: Gedung Perkuliahan Lt.2 R.204" required />
            <x-form.input label="Tanggal Kejadian" name="incident_date" type="date" required />
            <x-form.input label="Perkiraan Waktu (Opsional)" name="incident_time" type="time" />
            <div style="grid-column:span 2;">
                <x-form.textarea label="Ciri-Ciri Spesifik" name="description" required rows="4"
                    placeholder="Deskripsikan ciri unik barang: warna, merek, kondisi, label, dsb." />
            </div>
            <div style="grid-column:span 2;">
                <x-form.file label="Foto Barang (Opsional)" name="photo" />
            </div>
        </div>

        <div style="display:flex;gap:12px;margin-top:20px;padding-top:20px;border-top:1px solid var(--border);">
            <button type="submit" class="btn btn-yellow">Kirim Laporan</button>
            <a href="{{ route('items.my-reports') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
{{-- [/M3-LAPORAN] --}}
@endsection

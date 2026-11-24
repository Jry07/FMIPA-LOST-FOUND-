@extends('layouts.dashboard')

@section('title', 'Detail Kategori - Admin')
@section('page_title', 'Detail Kategori')

@section('content')
{{-- [M1-ADMIN] --}}
<x-page-header title="Detail Kategori" description="Informasi kategori barang" />
<div style="background: #ffffff; padding: 24px; border-radius: 12px; border: 1px solid var(--border);">
    <p>ID Kategori: {{ $id ?? '-' }}</p>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline" style="margin-top: 16px;">Kembali</a>
</div>
{{-- [/M1-ADMIN] --}}
@endsection

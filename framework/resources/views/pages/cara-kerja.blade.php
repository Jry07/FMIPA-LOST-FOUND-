@extends('layouts.app')

@section('title', 'Cara Kerja - FMIPA Lost & Found')

@section('content')
{{-- [M4-KATALOG] --}}
<x-page-header title="Cara Kerja Sistem" description="Panduan alur pelaporan, verifikasi klaim, hingga serah terima barang di FMIPA UHO" />

<div style="background: #ffffff; padding: 32px; border-radius: 14px; border: 1px solid var(--border); margin-bottom: 30px;">
    <h2 style="font-size: 1.5rem; margin-bottom: 20px;">1. Alur Barang Hilang (Lost)</h2>
    <p style="color: var(--gray); margin-bottom: 16px;">
        Jika Anda kehilangan barang di lingkungan FMIPA UHO:
    </p>
    <ol style="margin-left: 24px; line-height: 1.8; color: var(--dark);">
        <li>Masuk ke akun Anda dan pilih menu <strong>Laporkan Barang</strong> tipe <em>Lost</em>.</li>
        <li>Isi ciri barang, lokasi terakhir dilihat, dan tanggal kehilangan dengan akurat.</li>
        <li>Laporan akan diperiksa oleh Admin sebelum dipublikasikan di katalog.</li>
        <li>Jika ada civitas yang menemukan barang Anda, mereka dapat menekan tombol <strong>"Saya Menemukan Barang Ini"</strong>.</li>
    </ol>
</div>

<div style="background: #ffffff; padding: 32px; border-radius: 14px; border: 1px solid var(--border); margin-bottom: 30px;">
    <h2 style="font-size: 1.5rem; margin-bottom: 20px;">2. Alur Barang Ditemukan (Found) &amp; Klaim</h2>
    <p style="color: var(--gray); margin-bottom: 16px;">
        Jika Anda menemukan barang atau mencari barang Anda yang telah ditemukan:
    </p>
    <ol style="margin-left: 24px; line-height: 1.8; color: var(--dark);">
        <li>Penemu membuat laporan <strong>Found</strong> dan menitipkan barang fisik ke Petugas di Pos Keamanan.</li>
        <li>Pemilik yang merasa memiliki barang mengajukan <strong>Klaim Kepemilikan</strong> disertai bukti valid.</li>
        <li>Petugas/Admin memverifikasi keabsahan bukti klaim.</li>
        <li>Pemilik datang ke Pos Satpam membawa identitas (KTM/KTP) untuk proses pencocokan fisik dan serah terima.</li>
    </ol>
</div>
{{-- [/M4-KATALOG] --}}
@endsection

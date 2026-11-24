@extends('layouts.app')
@section('title', 'Daftar Akun - FMIPA Lost & Found')
@section('content')
{{-- [M2-AUTH] --}}
<div style="max-width:520px;margin:48px auto;">
    <div style="background:#fff;padding:36px 32px;border-radius:16px;border:1px solid var(--border);box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <h1 style="text-align:center;margin-bottom:4px;">Daftar Akun Baru</h1>
        <p style="text-align:center;color:var(--gray);font-size:0.9rem;margin-bottom:28px;">Khusus Civitas Akademika FMIPA UHO</p>

        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            <x-form.input label="Nama Lengkap" name="name" placeholder="Nama sesuai KTM" required />
            <x-form.input label="Nomor Induk Mahasiswa (NIM)" name="nim" placeholder="F1G125000" required
                helpText="NIM digunakan untuk memverifikasi kepemilikan barang" />
            <x-form.input label="Email Institusi" name="email" type="email" placeholder="nim@uho.ac.id" required />
            <x-form.input label="Kata Sandi" name="password" type="password" placeholder="Minimal 8 karakter" required />
            <x-form.input label="Konfirmasi Kata Sandi" name="password_confirmation" type="password" placeholder="Ulangi kata sandi" required />

            <button type="submit" class="btn btn-maroon" style="width:100%;margin-top:8px;">Daftar Sekarang</button>
        </form>

        <div style="margin-top:20px;text-align:center;padding-top:20px;border-top:1px solid var(--border);">
            <p style="font-size:0.9rem;color:var(--gray);">Sudah punya akun? <a href="{{ route('login') }}" style="font-weight:600;color:var(--maroon);">Masuk di sini</a></p>
        </div>
    </div>
</div>
{{-- [/M2-AUTH] --}}
@endsection

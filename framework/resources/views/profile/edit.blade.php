@extends('layouts.dashboard')
@section('title', 'Profil Saya')
@section('page_title', 'Pengaturan Profil')
@section('content')
{{-- [M2-AUTH] --}}
<x-page-header title="Profil Saya" description="Kelola informasi akun dan kata sandi Anda" />

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
    {{-- Form Update Profil --}}
    <div style="background:#fff;padding:24px;border-radius:12px;border:1px solid var(--border);">
        <h3 style="margin-bottom:20px;font-size:1.1rem;">Informasi Akun</h3>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf @method('PUT')
            <x-form.input label="Nama Lengkap" name="name" :value="Auth::user()->name" required />
            <x-form.input label="Email" name="email" type="email" :value="Auth::user()->email" required />
            <x-form.input label="NIM" name="nim" :value="Auth::user()->nim" placeholder="Hanya untuk pengguna mahasiswa" />
            <button type="submit" class="btn btn-yellow">Simpan Perubahan</button>
        </form>
    </div>

    {{-- Form Update Password --}}
    <div style="background:#fff;padding:24px;border-radius:12px;border:1px solid var(--border);">
        <h3 style="margin-bottom:20px;font-size:1.1rem;">Ubah Kata Sandi</h3>
        <form action="{{ route('profile.password') }}" method="POST">
            @csrf @method('PUT')
            <x-form.input label="Kata Sandi Lama" name="current_password" type="password" required />
            <x-form.input label="Kata Sandi Baru" name="password" type="password" required />
            <x-form.input label="Konfirmasi Kata Sandi Baru" name="password_confirmation" type="password" required />
            <button type="submit" class="btn btn-maroon">Perbarui Kata Sandi</button>
        </form>
    </div>
</div>
{{-- [/M2-AUTH] --}}
@endsection

@extends('layouts.app')
@section('title', 'Masuk - FMIPA Lost & Found')
@section('content')
{{-- [M2-AUTH] --}}
<div style="max-width:460px;margin:48px auto;">
    <div style="background:#fff;padding:36px 32px;border-radius:16px;border:1px solid var(--border);box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <h1 style="text-align:center;margin-bottom:4px;">Masuk ke Akun</h1>
        <p style="text-align:center;color:var(--gray);font-size:0.9rem;margin-bottom:28px;">Sistem Barang Hilang &amp; Ditemukan FMIPA UHO</p>

        <form action="{{ route('login.store') }}" method="POST">
            @csrf
            <x-form.input label="Email Institusi" name="email" type="email" placeholder="nim@uho.ac.id" required />
            <x-form.input label="Kata Sandi" name="password" type="password" placeholder="••••••••" required />

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <label style="display:flex;align-items:center;gap:8px;font-size:0.9rem;cursor:pointer;">
                    <input type="checkbox" name="remember"> Ingat saya
                </label>
            </div>

            <button type="submit" class="btn btn-maroon" style="width:100%;">Masuk</button>
        </form>

        <div style="margin-top:20px;text-align:center;padding-top:20px;border-top:1px solid var(--border);">
            <p style="font-size:0.9rem;color:var(--gray);">Belum punya akun? <a href="{{ route('register') }}" style="font-weight:600;color:var(--maroon);">Daftar di sini</a></p>
        </div>

        @if(app()->environment('local'))
        <div style="margin-top:16px;padding:14px;background:var(--cream);border-radius:8px;">
            <p style="font-size:0.8rem;font-weight:600;color:var(--maroon);margin-bottom:8px;">🛠️ Dev Quick Login:</p>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <a href="{{ route('dev.login','admin') }}" class="btn-sm btn-maroon">Admin</a>
                <a href="{{ route('dev.login','petugas') }}" class="btn-sm btn-cream">Petugas</a>
                <a href="{{ route('dev.login','pengguna') }}" class="btn-sm btn-yellow">Pengguna</a>
            </div>
        </div>
        @endif
    </div>
</div>
{{-- [/M2-AUTH] --}}
@endsection

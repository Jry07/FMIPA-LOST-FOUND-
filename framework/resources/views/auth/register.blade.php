@extends('layouts.app')

@section('title', 'Daftar - FMIPA Lost & Found')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/auth-landing.css') }}">
@endpush

@section('content')
<div class="m2-hero-wrapper">
    <div class="m2-container">
        <div class="m2-hero-grid">
            {{-- Sisi Kiri: Logo Bundar fmipa Lost & Found (Sesuai Figma hal. 14) --}}
            <div class="m2-badge-wrapper">
                <div class="m2-circle-badge">
                    <div class="m2-badge-text-fmipa">fmipa</div>
                    <div class="m2-badge-text-lostfound">
                        <span>Lost</span>
                        <span class="m2-badge-ampersand">&amp;</span>
                        <span>Found</span>
                    </div>
                </div>
            </div>

            {{-- Sisi Kanan: Form Daftar dalam Kartu Kaca --}}
            <div>
                <div class="m2-glass-card">
                    <div class="m2-card-header">
                        <h2 class="m2-card-title">Daftar</h2>
                        <p class="m2-card-subtitle">
                            Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
                        </p>
                    </div>

                    {{-- Pesan Kesalahan --}}
                    @if ($errors->any())
                        <div class="m2-alert m2-alert-danger">
                            Terdapat kesalahan pada isian formulir. Silakan periksa kembali.
                        </div>
                    @endif

                    <form action="{{ route('register.store') }}" method="POST" autocomplete="off">
                        @csrf

                        {{-- Nama Lengkap --}}
                        <div class="m2-form-group">
                            <label for="name" class="m2-form-label">Nama</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}" 
                                class="m2-form-control @error('name') is-invalid @enderror" 
                                placeholder="Nama lengkap" 
                                maxlength="100"
                                required 
                                autofocus
                            >
                            @error('name')
                                <span class="m2-error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email (SRS FR-01) --}}
                        <div class="m2-form-group">
                            <label for="email" class="m2-form-label">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                class="m2-form-control @error('email') is-invalid @enderror" 
                                placeholder="nama@uho.ac.id" 
                                required
                            >
                            @error('email')
                                <span class="m2-error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- NIM (SRS FR-01) --}}
                        <div class="m2-form-group">
                            <label for="nim" class="m2-form-label">NIM</label>
                            <input 
                                type="text" 
                                id="nim" 
                                name="nim" 
                                value="{{ old('nim') }}" 
                                class="m2-form-control @error('nim') is-invalid @enderror" 
                                placeholder="F1G125041" 
                                maxlength="15"
                                required
                            >
                            @error('nim')
                                <span class="m2-error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Kata Sandi --}}
                        <div class="m2-form-group">
                            <label for="password" class="m2-form-label">Kata Sandi</label>
                            <div class="m2-input-wrapper">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="m2-form-control @error('password') is-invalid @enderror" 
                                    placeholder="Kata sandi anda" 
                                    required
                                >
                                <button type="button" class="m2-btn-toggle-pw" data-target="password" aria-label="Tampilkan kata sandi">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <span class="m2-error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Konfirmasi Kata Sandi --}}
                        <div class="m2-form-group">
                            <label for="password_confirmation" class="m2-form-label">Konfirmasi Kata Sandi</label>
                            <div class="m2-input-wrapper">
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    class="m2-form-control" 
                                    placeholder="Konfirmasi kata sandi anda" 
                                    required
                                >
                                <button type="button" class="m2-btn-toggle-pw" data-target="password_confirmation" aria-label="Tampilkan konfirmasi kata sandi">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Tombol Daftar --}}
                        <button type="submit" class="m2-btn m2-btn-yellow m2-btn-block">
                            Daftar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/auth.js') }}"></script>
@endpush

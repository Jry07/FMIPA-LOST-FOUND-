@extends('layouts.app')

@section('title', 'Masuk - FMIPA Lost & Found')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/auth-landing.css') }}">
@endpush

@section('content')
<div class="m2-hero-wrapper">
    <div class="m2-container">
        <div class="m2-hero-grid">
            {{-- Sisi Kiri: Form Masuk dalam Kartu Kaca (Sesuai Figma hal. 13) --}}
            <div>
                <div class="m2-glass-card">
                    <div class="m2-card-header">
                        <h2 class="m2-card-title">Masuk</h2>
                        <p class="m2-card-subtitle">
                            Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
                        </p>
                    </div>

                    {{-- Pesan Sukses (misal dari pendaftaran) --}}
                    @if (session('success'))
                        <div class="m2-alert m2-alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Pesan Kesalahan Global --}}
                    @if ($errors->has('email') && !$errors->has('password'))
                        <div class="m2-alert m2-alert-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif

                    <form action="{{ route('login.store') }}" method="POST" autocomplete="off">
                        @csrf

                        {{-- Email (sesuai SRS) --}}
                        <div class="m2-form-group">
                            <label for="email" class="m2-form-label">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                class="m2-form-control @error('email') is-invalid @enderror" 
                                placeholder="Email anda" 
                                required 
                                autofocus
                            >
                            @error('email')
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

                        {{-- Ingat Saya --}}
                        <div class="m2-form-check">
                            <input type="checkbox" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Ingat Saya</label>
                        </div>

                        {{-- Tombol Masuk --}}
                        <button type="submit" class="m2-btn m2-btn-yellow m2-btn-block">
                            Masuk
                        </button>
                    </form>

                    @if(app()->environment('local'))
                    <div style="margin-top:16px;padding:12px;background:rgba(255,255,255,0.7);border-radius:8px;border:1px dashed #d4a373;">
                        <p style="font-size:0.8rem;font-weight:600;color:var(--maroon,#730000);margin-bottom:8px;">🛠️ Dev Quick Login:</p>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                            <a href="{{ route('dev.login','admin') }}" class="btn-sm btn-maroon" style="padding:4px 8px;border-radius:4px;font-size:0.75rem;">Admin</a>
                            <a href="{{ route('dev.login','petugas') }}" class="btn-sm btn-cream" style="padding:4px 8px;border-radius:4px;font-size:0.75rem;">Petugas</a>
                            <a href="{{ route('dev.login','pengguna') }}" class="btn-sm btn-yellow" style="padding:4px 8px;border-radius:4px;font-size:0.75rem;">Pengguna</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Sisi Kanan: Logo Bundar fmipa Lost & Found --}}
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
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/auth.js') }}"></script>
@endpush

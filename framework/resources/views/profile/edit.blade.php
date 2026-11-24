@extends('layouts.dashboard')

@section('title', 'Kelola Profil')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/auth-landing.css') }}">
@endpush

@section('dashboard')
<div class="m2-profile-container">
    {{-- Header Profil --}}
    <div class="m2-profile-header">
        <div class="m2-profile-breadcrumb">PROFIL PENGGUNA</div>
        <h1 class="m2-profile-title">Kelola Profil Saya</h1>
        <p class="m2-profile-subtitle">Lihat informasi akun dan perbarui nama serta kata sandi Anda.</p>
    </div>

    {{-- Alert Notifikasi Sukses --}}
    @if (session('success'))
        <div class="m2-alert m2-alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Alert Notifikasi Kesalahan --}}
    @if ($errors->any())
        <div class="m2-alert m2-alert-danger">
            Terdapat kesalahan pada isian form profil. Silakan periksa pesan kesalahan di bawah.
        </div>
    @endif

    <div class="m2-profile-grid">
        {{-- Kolom 1: Informasi Akun (Read-Only sesuai SRS FR-03) --}}
        <div class="m2-profile-card">
            <h3 class="m2-profile-card-title">Informasi Akun</h3>

            <div class="m2-form-group">
                <label class="m2-form-label">
                    Email
                    <span class="m2-readonly-badge">Read-Only</span>
                </label>
                <input 
                    type="email" 
                    class="m2-form-control" 
                    value="{{ $user->email }}" 
                    readonly 
                    disabled
                >
            </div>

            <div class="m2-form-group">
                <label class="m2-form-label">
                    NIM
                    <span class="m2-readonly-badge">Read-Only</span>
                </label>
                <input 
                    type="text" 
                    class="m2-form-control" 
                    value="{{ $user->nim ?? '-' }}" 
                    readonly 
                    disabled
                >
            </div>

            <div class="m2-form-group">
                <label class="m2-form-label">Peran (Role)</label>
                <div>
                    <span class="m2-role-pill">
                        {{ ucfirst($user->role ?? 'pengguna') }}
                    </span>
                </div>
            </div>

            <div class="m2-form-group">
                <label class="m2-form-label">Tanggal Terdaftar</label>
                <p style="font-family: var(--m2-font-body); font-size: 0.9rem; color: #555; margin: 0;">
                    {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}
                </p>
            </div>
        </div>

        {{-- Kolom 2: Form Ubah Nama & Kata Sandi --}}
        <div class="m2-profile-card">
            <h3 class="m2-profile-card-title">Perbarui Profil</h3>

            <form action="{{ route('profile.update') }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')

                {{-- Ubah Nama --}}
                <div class="m2-form-group">
                    <label for="name" class="m2-form-label">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $user->name) }}" 
                        class="m2-form-control @error('name') is-invalid @enderror" 
                        maxlength="100"
                        required
                    >
                    @error('name')
                        <span class="m2-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <hr style="border: none; border-top: 1px dashed #e2e8f0; margin: 1.5rem 0;">

                <div style="margin-bottom: 1rem;">
                    <strong style="font-family: var(--m2-font-body); font-size: 0.95rem; color: var(--m2-maroon);">
                        Ubah Kata Sandi (Opsional)
                    </strong>
                    <p style="font-family: var(--m2-font-body); font-size: 0.8rem; color: #718096; margin: 0.2rem 0 0 0;">
                        Biarkan kosong jika Anda tidak ingin mengubah kata sandi.
                    </p>
                </div>

                {{-- Kata Sandi Lama (current_password) --}}
                <div class="m2-form-group">
                    <label for="current_password" class="m2-form-label">Kata Sandi Saat Ini</label>
                    <div class="m2-input-wrapper">
                        <input 
                            type="password" 
                            id="current_password" 
                            name="current_password" 
                            class="m2-form-control @error('current_password') is-invalid @enderror" 
                            placeholder="Wajib diisi jika mengubah sandi"
                        >
                        <button type="button" class="m2-btn-toggle-pw" data-target="current_password" aria-label="Tampilkan kata sandi saat ini">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                        <span class="m2-error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kata Sandi Baru --}}
                <div class="m2-form-group">
                    <label for="password" class="m2-form-label">Kata Sandi Baru</label>
                    <div class="m2-input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="m2-form-control @error('password') is-invalid @enderror" 
                            placeholder="Minimal 8 karakter"
                        >
                        <button type="button" class="m2-btn-toggle-pw" data-target="password" aria-label="Tampilkan kata sandi baru">
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

                {{-- Konfirmasi Kata Sandi Baru --}}
                <div class="m2-form-group">
                    <label for="password_confirmation" class="m2-form-label">Konfirmasi Kata Sandi Baru</label>
                    <div class="m2-input-wrapper">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="m2-form-control" 
                            placeholder="Ulangi kata sandi baru"
                        >
                        <button type="button" class="m2-btn-toggle-pw" data-target="password_confirmation" aria-label="Tampilkan konfirmasi kata sandi baru">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div style="margin-top: 1.5rem;">
                    <button type="submit" class="m2-btn m2-btn-yellow">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- Fallback jika layout memakai @yield('content') --}}
@section('content')
    @yield('dashboard')
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/auth.js') }}"></script>
@endpush

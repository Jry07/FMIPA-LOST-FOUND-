{{-- [M1-ADMIN] --}}
@extends('layouts.dashboard')

@section('title', 'Kelola Akun Pengguna')
@section('page_title', 'Kelola Akun Pengguna')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/admin.css') }}">
@endpush

@section('content')

<x-page-header
    title="Daftar Akun Pengguna"
    subtitle="Lihat dan kelola peran (role) seluruh akun terdaftar"
/>

{{-- Form Pencarian --}}
<form method="GET" action="{{ route('admin.users.index') }}" class="search-form mb-4">
    <div class="search-group">
        <input
            type="text"
            name="search"
            class="search-input"
            placeholder="Cari nama, email, atau NIM..."
            value="{{ $search ?? '' }}"
        >
        <button type="submit" class="btn-maroon">🔍 Cari</button>
        @if($search)
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">✕ Reset</a>
        @endif
    </div>
    @if($search)
        <p class="search-hint">
            Menampilkan hasil untuk: <strong>"{{ $search }}"</strong>
            ({{ $users->total() }} akun ditemukan)
        </p>
    @endif
</form>

@if($users->isEmpty())
    <x-empty-state
        icon="👥"
        title="Tidak ada akun ditemukan"
        description="{{ $search ? 'Tidak ada akun yang cocok dengan kata kunci pencarian.' : 'Belum ada akun pengguna terdaftar.' }}"
    />
@else
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table-admin">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIM</th>
                            <th>Peran Saat Ini</th>
                            <th>Terdaftar</th>
                            <th class="text-center">Ubah Peran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $i => $user)
                        <tr class="{{ $user->id === auth()->id() ? 'row-self' : '' }}">
                            <td class="text-muted">{{ $users->firstItem() + $i }}</td>
                            <td>
                                <strong>{{ $user->name }}</strong>
                                @if($user->id === auth()->id())
                                    <span class="badge-self">Anda</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td class="text-muted">{{ $user->nim ?? '-' }}</td>
                            <td>
                                @php
                                    $roleBadge = match($user->role) {
                                        'admin'   => 'badge-role-admin',
                                        'petugas' => 'badge-role-petugas',
                                        default   => 'badge-role-pengguna',
                                    };
                                    $roleLabel = match($user->role) {
                                        'admin'   => 'Administrator',
                                        'petugas' => 'Petugas',
                                        default   => 'Pengguna',
                                    };
                                @endphp
                                <span class="role-badge {{ $roleBadge }}">{{ $roleLabel }}</span>
                            </td>
                            <td class="text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                @if($user->id === auth()->id())
                                    <span class="text-muted small">Tidak dapat diubah</span>
                                @else
                                    <form action="{{ route('admin.users.role', $user) }}"
                                          method="POST"
                                          class="role-form">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="select-role">
                                            <option value="pengguna" @selected($user->role === 'pengguna')>Pengguna</option>
                                            <option value="petugas"  @selected($user->role === 'petugas')>Petugas</option>
                                            <option value="admin"    @selected($user->role === 'admin')>Administrator</option>
                                        </select>
                                        <button type="submit"
                                                class="btn-sm btn-yellow"
                                                onclick="return confirm('Ubah peran akun {{ addslashes($user->name) }}?')">
                                            Simpan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Paginasi --}}
    @if($users->hasPages())
        <div class="mt-3">
            {{ $users->appends(['search' => $search])->links() }}
        </div>
    @endif
@endif

{{-- [/M1-ADMIN] --}}
@endsection

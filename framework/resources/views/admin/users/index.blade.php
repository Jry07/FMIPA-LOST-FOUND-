@extends('layouts.dashboard')

@section('title', 'Kelola Akun - Admin')
@section('page_title', 'Manajemen Akun Pengguna')

@section('content')
{{-- [M1-ADMIN] --}}
<x-page-header title="Daftar Akun Pengguna" description="Kelola peran dan status akun civitas akademika FMIPA" />

<div class="table-responsive">
    <table class="table-custom">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>NIM</th>
                <th>Peran Saat Ini</th>
                <th>Bergabung</th>
                <th style="text-align:center;">Ubah Peran</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Models\User::latest()->get() as $u)
            <tr>
                <td><strong>{{ $u->name }}</strong></td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->nim ?? '-' }}</td>
                <td><x-status-badge :status="$u->role" /></td>
                <td>{{ $u->created_at->format('d M Y') }}</td>
                <td style="text-align:center;">
                    <form action="{{ route('admin.users.update', $u) }}" method="POST" style="display:inline-flex;gap:8px;align-items:center;">
                        @csrf @method('PUT')
                        <select name="role" class="form-select" style="width:140px;padding:6px 10px;font-size:0.85rem;">
                            <option value="pengguna" {{ $u->role==='pengguna'?'selected':'' }}>Pengguna</option>
                            <option value="admin" {{ $u->role==='admin'?'selected':'' }}>Admin</option>
                            <option value="petugas" {{ $u->role==='petugas'?'selected':'' }}>Petugas</option>
                        </select>
                        <button type="submit" class="btn-sm btn-yellow">Simpan</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- [/M1-ADMIN] --}}
@endsection

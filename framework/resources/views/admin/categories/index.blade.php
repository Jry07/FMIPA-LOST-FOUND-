@extends('layouts.dashboard')

@section('title', 'Kelola Kategori - Admin')
@section('page_title', 'Master Data Kategori')

@section('content')
{{-- [M1-ADMIN] --}}
<x-page-header title="Daftar Kategori Barang" description="Kelola kategori barang untuk standardisasi laporan Lost & Found">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-yellow">➕ Tambah Kategori</a>
</x-page-header>

<div class="table-responsive">
    <table class="table-custom">
        <thead>
            <tr>
                <th style="width: 60px;">No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th style="width: 140px; text-align: center;">Jumlah Barang</th>
                <th style="width: 160px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $categories = \App\Models\Category::withCount('items')->get(); @endphp
            @forelse($categories as $idx => $cat)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td><strong>{{ $cat->name }}</strong></td>
                    <td style="color: var(--gray);">{{ $cat->description ?? '-' }}</td>
                    <td style="text-align: center;"><span class="badge badge-status-selesai">{{ $cat->items_count }} barang</span></td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.categories.edit', $cat) }}" class="btn-sm btn-cream">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 24px;">Belum ada data kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{-- [/M1-ADMIN] --}}
@endsection

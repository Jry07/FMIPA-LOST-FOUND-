{{-- [M1-ADMIN] --}}
@extends('layouts.dashboard')

@section('title', 'Kelola Kategori')
@section('page_title', 'Kelola Kategori')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/admin.css') }}">
@endpush

@section('content')

<x-page-header
    title="Daftar Kategori"
    subtitle="Kelola kategori barang untuk laporan Lost &amp; Found"
>
    <a href="{{ route('admin.categories.create') }}" class="btn-maroon">
        + Tambah Kategori
    </a>
</x-page-header>

@if($categories->isEmpty())
    <x-empty-state
        icon="🏷️"
        title="Belum ada kategori"
        description="Tambahkan kategori pertama untuk mulai mengelompokkan laporan barang."
    />
@else
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table-admin">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Jumlah Laporan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $i => $category)
                        <tr>
                            <td class="text-muted">{{ $categories->firstItem() + $i }}</td>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td class="text-muted">{{ $category->description ?: '-' }}</td>
                            <td class="text-center">
                                <span class="badge-count">{{ $category->items_count }}</span>
                            </td>
                            <td class="text-center">
                                <div class="action-group">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="btn-sm btn-outline-maroon">
                                        ✏️ Ubah
                                    </a>
                                    @if($category->items_count === 0)
                                        <form action="{{ route('admin.categories.destroy', $category) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Hapus kategori &quot;{{ addslashes($category->name) }}&quot;? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm btn-danger">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="btn-sm btn-disabled"
                                              title="Tidak dapat dihapus: dipakai oleh {{ $category->items_count }} laporan">
                                            🔒 Terkunci
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Paginasi --}}
    @if($categories->hasPages())
        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    @endif
@endif

{{-- [/M1-ADMIN] --}}
@endsection

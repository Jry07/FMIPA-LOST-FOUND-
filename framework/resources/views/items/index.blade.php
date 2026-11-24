@extends('layouts.app')

@section('title', 'Temukan Barang - FMIPA Lost & Found')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/katalog.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/modules/katalog.js') }}"></script>
@endpush

@section('content')
<div class="katalog-page">
    {{-- Header Banner Halaman (Pita Krem Konsisten) --}}
    <header class="katalog-header-banner">
        <div class="container">
            <h1 class="katalog-page-title">Temukan Barang</h1>
            <p class="katalog-page-subtitle">
                Cari barang hilang atau cek barang temuan di lingkungan FMIPA Universitas Halu Oleo.
            </p>
        </div>
    </header>

    <main class="container katalog-main-content">
        {{-- Bar Pencarian dan Filter (Kartu Putih Rounded) --}}
        @include('items.partials.filter-form')

        {{-- Keterangan Jumlah Hasil Pencarian --}}
        <div class="katalog-meta-info">
            <p class="katalog-results-count">
                Menampilkan <strong>{{ $items->total() }}</strong> laporan
                @if (request('status') === \App\Models\Item::STATUS_SELESAI)
                    berstatus <span class="text-maroon">Selesai</span>
                @else
                    berstatus <span class="text-maroon">Dipublikasikan</span>
                @endif
                @if (request('q'))
                    untuk pencarian <em>"{{ request('q') }}"</em>
                @endif
            </p>
        </div>

        {{-- Grid Daftar Barang (3 kolom desktop / 2 tablet / 1 ponsel) --}}
        @if ($items->count() > 0)
            <div class="katalog-grid">
                @foreach ($items as $item)
                    <a href="{{ route('items.show', $item) }}" class="katalog-card-anchor" aria-label="Lihat detail {{ $item->name }}">
                        <x-item-card :item="$item" />
                    </a>
                @endforeach
            </div>

            {{-- Pagination (9 laporan per halaman, mempertahankan query string) --}}
            <nav class="katalog-pagination" aria-label="Navigasi Halaman Katalog">
                {{ $items->links() }}
            </nav>
        @else
            {{-- Tampilan Data Kosong --}}
            <div class="katalog-empty-wrapper">
                <x-empty-state
                    title="Tidak Ada Laporan Ditemukan"
                    message="Tidak ada laporan barang yang sesuai dengan kata kunci atau filter yang Anda pilih. Silakan atur ulang filter pencarian Anda."
                >
                    <a href="{{ route('items.index') }}" class="btn btn-outline">
                        Reset Semua Filter
                    </a>
                </x-empty-state>
            </div>
        @endif
    </main>
</div>
@endsection

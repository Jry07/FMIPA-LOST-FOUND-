@extends('layouts.app')

@section('title', 'Detail Barang: ' . $item->name . ' - FMIPA Lost & Found')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/katalog.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/modules/katalog.js') }}"></script>
@endpush

@section('content')
@php
    // Pemetaan nama bulan dalam Bahasa Indonesia (NFR-07)
    $bulanIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    // Format Tanggal Kejadian (contoh: '02 November 2026, sekitar 17.30 WITA')
    $tanggalKejadianStr = '-';
    if ($item->incident_date) {
        $dateObj = \Carbon\Carbon::parse($item->incident_date);
        $tgl = str_pad($dateObj->day, 2, '0', STR_PAD_LEFT);
        $bln = $bulanIndo[$dateObj->month] ?? $dateObj->translatedFormat('F');
        $thn = $dateObj->year;
        $tanggalKejadianStr = "{$tgl} {$bln} {$thn}";

        if ($item->incident_time) {
            $waktuStr = \Carbon\Carbon::parse($item->incident_time)->format('H.i');
            $tanggalKejadianStr .= ", sekitar {$waktuStr} WITA";
        }
    }

    // Format Tanggal Laporan (contoh: '03 November 2026')
    $tanggalLaporanStr = '-';
    if ($item->created_at) {
        $laporObj = \Carbon\Carbon::parse($item->created_at);
        $tglL = str_pad($laporObj->day, 2, '0', STR_PAD_LEFT);
        $blnL = $bulanIndo[$laporObj->month] ?? $laporObj->translatedFormat('F');
        $thnL = $laporObj->year;
        $tanggalLaporanStr = "{$tglL} {$blnL} {$thnL}";
    }

    // Format Status Laporan
    if ($item->status === \App\Models\Item::STATUS_DIPUBLIKASIKAN) {
        $statusLaporanStr = 'Dipublikasikan - belum diserahterimakan';
    } elseif ($item->status === \App\Models\Item::STATUS_SELESAI) {
        $statusLaporanStr = 'Selesai - sudah diserahterimakan';
    } else {
        $statusLaporanStr = method_exists($item, 'statusLabel') ? $item->statusLabel() : ucfirst($item->status);
    }

    // Format Kode Laporan (mis. LAPORAN FND-026 atau LST-042)
    $kodeLaporan = $item->kode ?? (
        ($item->type === \App\Models\Item::TYPE_FOUND ? 'FND-' : 'LST-') . str_pad($item->id, 3, '0', STR_PAD_LEFT)
    );
@endphp

<div class="katalog-detail-page">
    {{-- Pita Krem Judul Halaman (Figma Hal. 10) --}}
    <section class="detail-header-ribbon">
        <div class="container">
            <h1 class="detail-ribbon-title">Detail Barang</h1>
        </div>
    </section>

    <main class="container detail-main-container">
        {{-- Kontainer Dua Kolom: Kiri Foto, Kanan Informasi (Figma Hal. 10) --}}
        <div class="detail-two-columns">
            {{-- Kolom Kiri: Foto Barang Rounded --}}
            <div class="detail-media-column">
                <div class="detail-photo-wrapper">
                    @if ($item->photo)
                        <img
                            src="{{ filter_var($item->photo, FILTER_VALIDATE_URL) ? $item->photo : asset('storage/' . $item->photo) }}"
                            alt="Foto {{ $item->name }}"
                            class="detail-photo"
                            loading="lazy"
                        >
                    @else
                        {{-- Placeholder jika tidak ada foto --}}
                        <div class="detail-photo-placeholder" role="img" aria-label="Tidak ada foto barang">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="placeholder-icon">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <span class="placeholder-text">Foto tidak tersedia</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Kolom Kanan: Rincian Informasi Barang --}}
            <div class="detail-info-column">
                {{-- Badges: Jenis Laporan & Status Laporan --}}
                <div class="detail-badges-group">
                    <x-type-badge :type="$item->type" />
                    <x-status-badge :status="$item->status" />
                </div>

                {{-- Kode Laporan (contoh: LAPORAN FND-026) --}}
                <div class="detail-kode-laporan">
                    LAPORAN {{ strtoupper($kodeLaporan) }}
                </div>

                {{-- Nama Barang (Serif Marun Besar sesuai Figma) --}}
                <h2 class="detail-item-name">
                    {{ $item->name }}
                </h2>

                {{-- Deskripsi Barang --}}
                <div class="detail-description">
                    <p>{{ $item->description }}</p>
                </div>

                {{-- Garis Pemisah Tipis di Bawah Deskripsi (Figma Hal. 10) --}}
                <hr class="detail-divider">

                {{-- Daftar Informasi (Label Kecil Abu di Atas Nilai Tebal) --}}
                <dl class="detail-info-list">
                    {{-- 1. Kategori --}}
                    <div class="detail-info-item">
                        <dt class="info-label">Kategori</dt>
                        <dd class="info-value">{{ $item->category->name ?? '-' }}</dd>
                    </div>

                    {{-- 2. Jenis Laporan --}}
                    <div class="detail-info-item">
                        <dt class="info-label">Jenis laporan</dt>
                        <dd class="info-value">
                            {{ $item->type === \App\Models\Item::TYPE_FOUND ? 'Barang Ditemukan' : 'Barang Hilang' }}
                        </dd>
                    </div>

                    {{-- 3. Lokasi Penemuan / Kehilangan --}}
                    <div class="detail-info-item">
                        <dt class="info-label">
                            {{ $item->type === \App\Models\Item::TYPE_FOUND ? 'Lokasi penemuan' : 'Lokasi kehilangan' }}
                        </dt>
                        <dd class="info-value">{{ $item->location }}</dd>
                    </div>

                    {{-- 4. Tanggal Kejadian --}}
                    <div class="detail-info-item">
                        <dt class="info-label">Tanggal kejadian</dt>
                        <dd class="info-value">{{ $tanggalKejadianStr }}</dd>
                    </div>

                    {{-- 5. Tanggal Laporan --}}
                    <div class="detail-info-item">
                        <dt class="info-label">Tanggal laporan</dt>
                        <dd class="info-value">{{ $tanggalLaporanStr }}</dd>
                    </div>

                    {{-- 6. Status Laporan --}}
                    <div class="detail-info-item">
                        <dt class="info-label">Status laporan</dt>
                        <dd class="info-value">{{ $statusLaporanStr }}</dd>
                    </div>
                </dl>

                {{-- Slot Milik Modul M5: Tombol Aksi (Ajukan Klaim / Laporkan Penemuan) --}}
                <div class="detail-action-slot">
                    @include('claims.partials.action-button', ['item' => $item])
                </div>
            </div>
        </div>

        {{-- Slot Milik Modul M5: Kotak Alur Informasi di Bawah Kedua Kolom (Figma Hal. 10) --}}
        <div class="detail-info-steps-slot">
            @include('claims.partials.info-steps', ['item' => $item])
        </div>
    </main>
</div>
@endsection

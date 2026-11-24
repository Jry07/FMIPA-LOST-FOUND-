@extends('layouts.dashboard')

@section('title', 'Dashboard Pengguna - FMIPA Lost & Found')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/laporan-dashboard.css') }}">
@endpush

@section('content')
<div class="dashboard-wrapper">
    {{-- Header Dashboard (Sesuai Figma Hal. 3) --}}
    <div class="dashboard-page-header">
        <div>
            <div class="dashboard-pretitle">DASHBOARD PENGGUNA</div>
            <h1 class="dashboard-title">Halo {{ auth()->user()->name }}.</h1>
            <p class="dashboard-subtitle">Semua laporan dan perkembangan klaim Anda, dalam satu tempat.</p>
        </div>
        <div>
            <a href="{{ route('reports.create') }}" class="btn-m3-primary">
                Buat Laporan +
            </a>
        </div>
    </div>

    {{-- 4 Kartu Statistik (Sesuai Figma Hal. 3) --}}
    <div class="stats-grid">
        {{-- Stat 1: Total Laporan --}}
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <span class="stat-label">Total laporan</span>
                <span class="stat-subtext">{{ $laporanMenunggu }} masih diverifikasi</span>
            </div>
            <div class="stat-number">{{ $totalLaporan }}</div>
        </div>

        {{-- Stat 2: Total Klaim --}}
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                </div>
                <span class="stat-label">Total klaim</span>
                <span class="stat-subtext">Riwayat pengajuan Anda</span>
            </div>
            <div class="stat-number">{{ $totalKlaim }}</div>
        </div>

        {{-- Stat 3: Klaim Diperiksa --}}
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <span class="stat-label">Klaim diperiksa</span>
                <span class="stat-subtext">Menunggu hasil petugas</span>
            </div>
            <div class="stat-number">{{ $klaimDiperiksa }}</div>
        </div>

        {{-- Stat 4: Laporan Selesai --}}
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <span class="stat-label">Laporan selesai</span>
                <span class="stat-subtext">Barang telah kembali</span>
            </div>
            <div class="stat-number">{{ $laporanSelesai }}</div>
        </div>
    </div>

    {{-- Grid 2 Kolom: Laporan Terbaru (Kiri) & Notifikasi Terbaru (Kanan) --}}
    <div class="dashboard-two-col">
        {{-- Card Laporan Terbaru --}}
        <div class="dashboard-card">
            <h2 class="dashboard-card-title">Laporan Terbaru</h2>
            @if ($laporanTerbaru)
                <div class="latest-report-box">
                    <div class="latest-report-img-wrapper">
                        @if ($laporanTerbaru->photo)
                            <img src="{{ asset('storage/' . $laporanTerbaru->photo) }}" alt="{{ $laporanTerbaru->name }}" class="latest-report-img">
                        @else
                            <div class="latest-report-img-placeholder">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                                <span>Tanpa Foto</span>
                            </div>
                        @endif
                    </div>
                    <div class="latest-report-content">
                        <div class="latest-report-meta">
                            {{ $laporanTerbaru->kode ?? ('LST-' . str_pad($laporanTerbaru->id, 3, '0', STR_PAD_LEFT)) }} · {{ $laporanTerbaru->type === 'lost' ? 'Barang Hilang' : 'Barang Temuan' }}
                        </div>
                        <h3 class="latest-report-name">{{ $laporanTerbaru->name }}</h3>
                        <div>
                            <x-status-badge :status="$laporanTerbaru->status" />
                        </div>
                        <div class="latest-report-meta" style="margin-top: 4px;">
                            {{ $laporanTerbaru->location }} · {{ \Carbon\Carbon::parse($laporanTerbaru->incident_date)->translatedFormat('d F Y') }}
                        </div>
                        <p class="latest-report-desc">
                            {{ $laporanTerbaru->description }}
                        </p>
                        <div>
                            <a href="{{ route('items.show', $laporanTerbaru) }}" class="btn-m3-outline" style="padding: 6px 14px; font-size: 13px;">
                                Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <x-empty-state message="Belum ada laporan yang Anda buat." action-text="Buat Laporan" :action-url="route('reports.create')" />
            @endif
        </div>

        {{-- Card Notifikasi Terbaru --}}
        <div class="dashboard-card">
            <h2 class="dashboard-card-title">Notifikasi Terbaru</h2>
            @if ($notifikasiTerbaru->isNotEmpty())
                <div class="notifications-mini-list">
                    @foreach ($notifikasiTerbaru as $notif)
                        <div class="notification-mini-item">
                            <div class="notification-mini-icon">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg>
                            </div>
                            <div class="notification-mini-content">
                                <div class="notification-mini-title">{{ $notif->data['title'] ?? ($notif->data['judul'] ?? 'Pemberitahuan') }}</div>
                                <div class="notification-mini-desc">{{ $notif->data['message'] ?? ($notif->data['pesan'] ?? 'Ada pembaruan status pada laporan atau klaim Anda.') }}</div>
                                <div class="notification-mini-time">{{ $notif->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer-link">
                    <a href="{{ route('notifications.index') }}" class="link-maroon">Lihat semua &rarr;</a>
                </div>
            @else
                <x-empty-state message="Belum ada notifikasi terbaru." />
            @endif
        </div>
    </div>

    {{-- Section Perkembangan Klaim Anda --}}
    <div class="claim-progress-card">
        <div class="claim-progress-header">
            <h2 class="claim-progress-title">Perkembangan Klaim Anda</h2>
            @if ($klaimTerbaru)
                <x-status-badge :status="$klaimTerbaru->status" />
            @endif
        </div>

        @if ($klaimTerbaru)
            <div class="claim-progress-item-name">
                {{ $klaimTerbaru->kode ?? ('KLM-' . str_pad($klaimTerbaru->id, 3, '0', STR_PAD_LEFT)) }} · {{ $klaimTerbaru->item->name ?? 'Barang' }}
            </div>
            <div class="claim-progress-subtext">
                Bukti Anda sudah diterima dan sedang diproses verifikasinya oleh petugas.
            </div>
            <div>
                <x-claim-stepper :claim="$klaimTerbaru" />
            </div>
        @else
            <x-empty-state message="Anda belum memiliki pengajuan klaim aktif saat ini." />
        @endif
    </div>

    {{-- Section Riwayat Laporan (Tabel dengan Header Krem) --}}
    <div class="history-section-card">
        <h2 class="dashboard-card-title">Riwayat Laporan</h2>
        @if ($riwayatLaporan->isNotEmpty())
            <div class="table-responsive">
                <table class="m3-table">
                    <thead>
                        <tr>
                            <th>Laporan / barang</th>
                            <th>Jenis / lokasi</th>
                            <th>Tanggal laporan</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayatLaporan as $laporan)
                            <tr>
                                <td>
                                    <strong>{{ $laporan->kode ?? ('LST-' . str_pad($laporan->id, 3, '0', STR_PAD_LEFT)) }}</strong> · {{ $laporan->name }}
                                </td>
                                <td>
                                    {{ $laporan->type === 'lost' ? 'Hilang' : 'Ditemukan' }} · {{ $laporan->location }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporan->incident_date)->translatedFormat('d M Y') }}
                                </td>
                                <td>
                                    <x-status-badge :status="$laporan->status" />
                                </td>
                                <td>
                                    <a href="{{ route('items.show', $laporan) }}" class="link-maroon">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-empty-state message="Belum ada riwayat laporan barang." />
        @endif
    </div>

    {{-- Section Riwayat Klaim (Tabel dengan Header Krem) --}}
    <div class="history-section-card">
        <h2 class="dashboard-card-title">Riwayat Klaim</h2>
        @if ($riwayatKlaim->isNotEmpty())
            <div class="table-responsive">
                <table class="m3-table">
                    <thead>
                        <tr>
                            <th>Klaim / barang</th>
                            <th>Laporan / kategori</th>
                            <th>Tanggal pengajuan</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayatKlaim as $klaim)
                            <tr>
                                <td>
                                    <strong>{{ $klaim->kode ?? ('KLM-' . str_pad($klaim->id, 3, '0', STR_PAD_LEFT)) }}</strong> · {{ $klaim->item->name ?? 'Barang' }}
                                </td>
                                <td>
                                    {{ $klaim->item->kode ?? '-' }} · {{ $klaim->item->category->name ?? 'Kategori' }}
                                </td>
                                <td>
                                    {{ $klaim->created_at->translatedFormat('d M Y') }}
                                </td>
                                <td>
                                    <x-status-badge :status="$klaim->status" />
                                </td>
                                <td>
                                    <a href="{{ route('my-claims.show', $klaim) }}" class="link-maroon">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-empty-state message="Belum ada riwayat pengajuan klaim." />
        @endif
    </div>
</div>
@endsection

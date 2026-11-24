{{-- [M1-ADMIN] --}}
@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/admin.css') }}">
@endpush

@section('content')

{{-- Kartu Aksi Cepat --}}
<div class="admin-quick-actions mb-4">
    <a href="{{ route('verification.items.index') }}" class="quick-action-card quick-action-warning">
        <div class="qa-icon">📋</div>
        <div class="qa-info">
            <span class="qa-count">{{ $menanggguVerifikasi }}</span>
            <span class="qa-label">Laporan menunggu verifikasi</span>
        </div>
        <span class="qa-arrow">→</span>
    </a>
    <a href="{{ route('verification.claims.index') }}" class="quick-action-card quick-action-info">
        <div class="qa-icon">⚖️</div>
        <div class="qa-info">
            <span class="qa-count">{{ $menungguPemeriksaan }}</span>
            <span class="qa-label">Pengajuan menunggu pemeriksaan</span>
        </div>
        <span class="qa-arrow">→</span>
    </a>
</div>

{{-- Statistik Laporan per Status --}}
<x-page-header title="Statistik Sistem" subtitle="Ringkasan data laporan, klaim, dan akun pengguna" />

<div class="stats-grid mb-4">
    <div class="stat-card stat-warning">
        <div class="stat-icon">⏳</div>
        <div class="stat-value">{{ $totalPerStatus['menunggu'] }}</div>
        <div class="stat-label">Menunggu Verifikasi</div>
    </div>
    <div class="stat-card stat-success">
        <div class="stat-icon">✅</div>
        <div class="stat-value">{{ $totalPerStatus['dipublikasikan'] }}</div>
        <div class="stat-label">Dipublikasikan</div>
    </div>
    <div class="stat-card stat-danger">
        <div class="stat-icon">❌</div>
        <div class="stat-value">{{ $totalPerStatus['ditolak'] }}</div>
        <div class="stat-label">Ditolak</div>
    </div>
    <div class="stat-card stat-secondary">
        <div class="stat-icon">🚫</div>
        <div class="stat-value">{{ $totalPerStatus['dibatalkan'] }}</div>
        <div class="stat-label">Dibatalkan</div>
    </div>
    <div class="stat-card stat-primary">
        <div class="stat-icon">🏁</div>
        <div class="stat-value">{{ $totalPerStatus['selesai'] }}</div>
        <div class="stat-label">Selesai</div>
    </div>
    <div class="stat-card stat-dark">
        <div class="stat-icon">📦</div>
        <div class="stat-value">{{ $totalLaporan }}</div>
        <div class="stat-label">Total Laporan</div>
    </div>
</div>

{{-- Statistik Tipe Laporan & Klaim & Akun --}}
<div class="admin-row-3 mb-4">
    {{-- Tipe Laporan --}}
    <div class="card">
        <div class="card-header-cream">
            <h6 class="card-title-sm">📂 Laporan per Tipe</h6>
        </div>
        <div class="card-body">
            <div class="mini-stat">
                <span class="mini-label">🔴 Barang Hilang (Lost)</span>
                <span class="mini-value">{{ $totalLost }}</span>
            </div>
            <div class="mini-stat">
                <span class="mini-label">🟢 Barang Ditemukan (Found)</span>
                <span class="mini-value">{{ $totalFound }}</span>
            </div>
        </div>
    </div>

    {{-- Klaim per Status --}}
    <div class="card">
        <div class="card-header-cream">
            <h6 class="card-title-sm">📝 Pengajuan per Status</h6>
        </div>
        <div class="card-body">
            <div class="mini-stat">
                <span class="mini-label">🟡 Diajukan</span>
                <span class="mini-value">{{ $totalKlaimPerStatus['diajukan'] }}</span>
            </div>
            <div class="mini-stat">
                <span class="mini-label">🟢 Diterima</span>
                <span class="mini-value">{{ $totalKlaimPerStatus['diterima'] }}</span>
            </div>
            <div class="mini-stat">
                <span class="mini-label">🔴 Ditolak</span>
                <span class="mini-value">{{ $totalKlaimPerStatus['ditolak'] }}</span>
            </div>
            <div class="mini-stat border-top pt-2 mt-2">
                <span class="mini-label">🤝 Serah Terima Selesai</span>
                <span class="mini-value">{{ $totalHandover }}</span>
            </div>
        </div>
    </div>

    {{-- Akun per Peran --}}
    <div class="card">
        <div class="card-header-cream">
            <h6 class="card-title-sm">👥 Akun per Peran</h6>
        </div>
        <div class="card-body">
            <div class="mini-stat">
                <span class="mini-label">👤 Pengguna</span>
                <span class="mini-value">{{ $totalPerRole['pengguna'] }}</span>
            </div>
            <div class="mini-stat">
                <span class="mini-label">🛡️ Admin</span>
                <span class="mini-value">{{ $totalPerRole['admin'] }}</span>
            </div>
            <div class="mini-stat">
                <span class="mini-label">👮 Petugas</span>
                <span class="mini-value">{{ $totalPerRole['petugas'] }}</span>
            </div>
            <div class="mini-stat border-top pt-2 mt-2">
                <span class="mini-label"><strong>Total Akun</strong></span>
                <span class="mini-value"><strong>{{ $totalAkun }}</strong></span>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Laporan Terbaru --}}
<div class="card">
    <div class="card-header-cream d-flex justify-content-between align-items-center">
        <h6 class="card-title-sm mb-0">🕐 Laporan Terbaru</h6>
        <a href="{{ route('verification.items.index') }}" class="btn-sm-link">Lihat semua →</a>
    </div>
    <div class="card-body p-0">
        @if($laporanTerbaru->isEmpty())
            <x-empty-state icon="📋" title="Belum ada laporan" description="Belum ada data laporan masuk." />
        @else
            <div class="table-responsive">
                <table class="table-admin">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Tipe</th>
                            <th>Pelapor</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporanTerbaru as $item)
                        <tr>
                            <td><code class="item-kode">{{ $item->kode }}</code></td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category?->name ?? '-' }}</td>
                            <td><x-type-badge :type="$item->type" /></td>
                            <td>{{ $item->user?->name ?? '-' }}</td>
                            <td><x-status-badge :status="$item->status" /></td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- [/M1-ADMIN] --}}
@endsection

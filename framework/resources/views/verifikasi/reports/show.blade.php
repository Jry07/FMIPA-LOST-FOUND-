@extends('layouts.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/verifikasi.css') }}">
@endpush

@section('dashboard')
    <x-page-header 
        title="Detail Laporan: {{ $item->kode }}" 
        subtitle="Periksa kebenaran data dan kelayakan laporan sebelum dipublikasikan."
    >
        <x-slot:actions>
            <a href="{{ route('verifikasi.reports.index') }}" class="btn btn-sm btn-outline-secondary">
                ← Kembali ke Daftar
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="detail-grid">
        {{-- Kolom Kiri: Foto & Ringkasan Laporan --}}
        <div class="detail-media-card">
            <div class="detail-image-wrapper">
                @if ($item->photo)
                    <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}">
                @else
                    <div class="detail-image-placeholder">📦</div>
                @endif
            </div>

            <div class="detail-summary-body">
                <div class="detail-code">{{ $item->kode }}</div>
                <h2 class="detail-item-title">{{ $item->name }}</h2>

                <div style="margin-bottom: 1rem; display: flex; gap: 0.5rem; align-items: center;">
                    <x-type-badge :type="$item->type" />
                    <x-status-badge :status="$item->status" />
                </div>

                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">Kategori</span>
                        <span class="info-value">{{ $item->category?->name ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Lokasi Kejadian</span>
                        <span class="info-value">📍 {{ $item->location }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal Kejadian</span>
                        <span class="info-value">{{ $item->incident_date?->format('d M Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Waktu Kejadian</span>
                        <span class="info-value">{{ $item->incident_time ? date('H:i', strtotime($item->incident_time)) . ' WITA' : '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Waktu Dilaporkan</span>
                        <span class="info-value">{{ $item->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Detail Deskripsi, Data Pelapor, & Aksi Admin --}}
        <div class="detail-content-card">
            <div class="section-box">
                <h3 class="section-title">👤 Data Pelapor</h3>
                <div class="user-identity-box">
                    <div class="user-avatar-circle">
                        {{ strtoupper(substr($item->user->name, 0, 1)) }}
                    </div>
                    <div class="user-identity-info">
                        <h4>{{ $item->user->name }}</h4>
                        <p>NIM: <strong>{{ $item->user->nim ?? '-' }}</strong> &bull; Email: {{ $item->user->email }}</p>
                        <p style="margin-top: 0.25rem; font-size: 0.8rem; color: var(--text-muted);">
                            Role Akun: {{ ucfirst($item->user->role) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="section-box">
                <h3 class="section-title">📄 Deskripsi Barang</h3>
                <div class="section-text">
                    {{ $item->description }}
                </div>
            </div>

            @if ($item->histories->count() > 0)
                <div class="section-box">
                    <h3 class="section-title">📜 Riwayat Status Laporan</h3>
                    <div class="table-responsive">
                        <table class="table" style="font-size: 0.85rem;">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Oleh</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->histories as $history)
                                    <tr>
                                        <td>{{ $history->created_at->format('d M Y, H:i') }}</td>
                                        <td>{{ $history->user?->name ?? 'Sistem' }}</td>
                                        <td><x-status-badge :status="$history->new_status" /></td>
                                        <td>{{ $history->note ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Tombol Aksi Verifikasi --}}
            <div class="action-box">
                <h3 class="section-title" style="margin-bottom: 0.5rem;">⚖️ Tindakan Verifikasi Admin</h3>
                <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                    Pastikan informasi barang dan foto yang diunggah valid serta tidak melanggar ketentuan kampus sebelum menyetujui laporan.
                </p>

                @if ($item->status === \App\Models\Item::STATUS_MENUNGGU)
                    <div class="action-buttons-row">
                        {{-- Form Setujui --}}
                        <form action="{{ route('verifikasi.reports.approve', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI dan mempublikasikan laporan ini?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary">
                                ✓ Setujui &amp; Publikasikan
                            </button>
                        </form>

                        {{-- Form Tolak --}}
                        <form action="{{ route('verifikasi.reports.reject', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK laporan ini? Laporan yang ditolak tidak akan dipublikasikan.');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger">
                                ✕ Tolak Laporan
                            </button>
                        </form>
                    </div>
                @else
                    <div class="alert alert-info" style="margin-bottom: 0;">
                        Laporan ini telah diproses dengan status: <strong>{{ $item->statusLabel() }}</strong>.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

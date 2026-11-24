@extends('layouts.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/verifikasi.css') }}">
@endpush

@section('dashboard')
    <x-page-header 
        title="Detail Pengajuan: {{ $claim->kode }}" 
        subtitle="Verifikasi bukti dan rincian pengajuan {{ $claim->type === \App\Models\Claim::TYPE_KLAIM ? 'klaim kepemilikan' : 'penemuan barang' }}."
    >
        <x-slot:actions>
            <a href="{{ route('verifikasi.claims.index') }}" class="btn btn-sm btn-outline-secondary">
                ← Kembali ke Daftar
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="detail-grid">
        {{-- Kolom Kiri: Ringkasan Barang Terkait --}}
        <div class="detail-media-card">
            <div class="detail-image-wrapper">
                @if ($claim->item->photo)
                    <img src="{{ asset('storage/' . $claim->item->photo) }}" alt="{{ $claim->item->name }}">
                @else
                    <div class="detail-image-placeholder">📦</div>
                @endif
            </div>

            <div class="detail-summary-body">
                <div class="detail-code">Laporan: {{ $claim->item->kode }}</div>
                <h2 class="detail-item-title">{{ $claim->item->name }}</h2>

                <div style="margin-bottom: 1rem; display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                    <x-type-badge :type="$claim->item->type" />
                    <x-status-badge :status="$claim->item->status" />
                </div>

                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">Kategori</span>
                        <span class="info-value">{{ $claim->item->category?->name ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Lokasi Kejadian Laporan</span>
                        <span class="info-value">📍 {{ $claim->item->location }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal Kejadian</span>
                        <span class="info-value">{{ $claim->item->incident_date?->format('d M Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Pembuat Laporan</span>
                        <span class="info-value">{{ $claim->item->user->name }} (NIM: {{ $claim->item->user->nim ?? '-' }})</span>
                    </div>
                </div>

                <div style="margin-top: 1.25rem;">
                    <span style="font-size: 0.85rem; font-weight: 600; color: var(--text-dark); display: block; margin-bottom: 0.25rem;">
                        Deskripsi Laporan Awal:
                    </span>
                    <p style="font-size: 0.875rem; color: var(--text-muted); line-height: 1.5; background: #FAF8F5; padding: 0.75rem; border-radius: 4px;">
                        {{ $claim->item->description }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Rincian Pengajuan, Identitas Pengaju, Bukti, & Verifikasi --}}
        <div class="detail-content-card">
            {{-- Data Pengaju --}}
            <div class="section-box">
                <h3 class="section-title">
                    👤 Data Pengaju ({{ $claim->type === \App\Models\Claim::TYPE_KLAIM ? 'Pemilik yang Mengklaim' : 'Penemu Barang' }})
                </h3>
                <div class="user-identity-box">
                    <div class="user-avatar-circle">
                        {{ strtoupper(substr($claim->submitter->name, 0, 1)) }}
                    </div>
                    <div class="user-identity-info">
                        <h4>{{ $claim->submitter->name }}</h4>
                        <p>NIM: <strong>{{ $claim->submitter->nim ?? '-' }}</strong> &bull; Email: {{ $claim->submitter->email }}</p>
                        <p style="margin-top: 0.25rem; font-size: 0.8rem; color: var(--text-muted);">
                            Jenis Pengajuan: <x-type-badge :type="$claim->type" /> &bull; Diajukan: {{ $claim->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Isi Pengajuan Berdasarkan Jenis --}}
            @if ($claim->type === \App\Models\Claim::TYPE_KLAIM)
                {{-- Kasus Klaim Kepemilikan pada Laporan Found --}}
                <div class="section-box">
                    <h3 class="section-title">📝 Deskripsi Ciri &amp; Bukti Kepemilikan</h3>
                    <div class="section-text">
                        {{ $claim->ownership_description ?? 'Tidak ada deskripsi kepemilikan yang disertakan.' }}
                    </div>
                </div>
            @else
                {{-- Kasus Pelaporan Penemuan pada Laporan Lost --}}
                <div class="section-box">
                    <h3 class="section-title">🔍 Rincian Penemuan Barang</h3>
                    <div class="info-list" style="margin-top: 0; padding-top: 0; border-top: none; margin-bottom: 0.75rem;">
                        <div class="info-row">
                            <span class="info-label">Lokasi Ditemukan</span>
                            <span class="info-value">📍 {{ $claim->finding_location ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Waktu Ditemukan</span>
                            <span class="info-value">{{ $claim->finding_time?->format('d M Y, H:i') ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Lokasi Penyimpanan / Penitipan</span>
                            <span class="info-value">🏢 {{ $claim->storage_location ?? '-' }}</span>
                        </div>
                    </div>

                    <span style="font-size: 0.85rem; font-weight: 600; color: var(--text-dark); display: block; margin-bottom: 0.25rem;">
                        Deskripsi Penemuan &amp; Kondisi Barang:
                    </span>
                    <div class="section-text">
                        {{ $claim->finding_description ?? 'Tidak ada deskripsi penemuan.' }}
                    </div>
                </div>
            @endif

            {{-- Bukti Pendukung (NFR-05) --}}
            <div class="section-box">
                <h3 class="section-title">📎 Berkas Bukti Pendukung</h3>
                @if ($claim->evidence)
                    <div class="evidence-box">
                        <div class="evidence-info">
                            <span>📄</span>
                            <span>Bukti Lampiran Pengajuan ({{ basename($claim->evidence) }})</span>
                        </div>
                        <a href="{{ route('claims.evidence', $claim) }}" target="_blank" class="btn btn-sm btn-yellow">
                            👁️ Buka Bukti
                        </a>
                    </div>
                @else
                    <p style="font-size: 0.875rem; color: var(--text-muted); font-style: italic;">
                        Tidak ada berkas bukti yang dilampirkan pada pengajuan ini.
                    </p>
                @endif
            </div>

            {{-- Tindakan Verifikasi --}}
            <div class="action-box">
                <h3 class="section-title" style="margin-bottom: 0.5rem;">⚖️ Tindakan Verifikasi Pengajuan</h3>
                <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                    Bila bukti dan deskripsi dinyatakan valid, status pengajuan akan diubah menjadi <strong>Diterima</strong> dan pengaju dapat melanjutkan serah terima bersama petugas.
                </p>

                @if ($claim->status === \App\Models\Claim::STATUS_DIAJUKAN)
                    @if ($claim->item->status === \App\Models\Item::STATUS_DIPUBLIKASIKAN)
                        <div class="action-buttons-row">
                            {{-- Form Terima --}}
                            <form action="{{ route('verifikasi.claims.accept', $claim) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENERIMA pengajuan ini? Notifikasi akan dikirimkan ke pihak terkait untuk serah terima.');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary">
                                    ✓ Terima Pengajuan
                                </button>
                            </form>

                            {{-- Form Tolak --}}
                            <form action="{{ route('verifikasi.claims.reject', $claim) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK pengajuan ini?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-danger">
                                    ✕ Tolak Pengajuan
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-danger" style="margin-bottom: 0;">
                            ⚠️ Pengajuan ini tidak dapat diproses karena status laporan barang saat ini adalah <strong>{{ $claim->item->statusLabel() }}</strong> (sesuai aturan SRS, hanya laporan berstatus Dipublikasikan yang dapat diverifikasi).
                        </div>
                    @endif
                @else
                    <div class="alert alert-info" style="margin-bottom: 0;">
                        Pengajuan ini telah diverifikasi sebelumnya dengan status: <strong>{{ $claim->statusLabel() }}</strong>
                        @if ($claim->verified_at)
                            pada {{ $claim->verified_at->format('d M Y, H:i') }}
                        @endif
                        @if ($claim->verifier)
                            oleh {{ $claim->verifier->name }} ({{ ucfirst($claim->verifier->role) }}).
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

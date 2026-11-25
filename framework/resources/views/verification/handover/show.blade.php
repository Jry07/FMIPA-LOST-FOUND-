{{-- [M6-VERIFIKASI] --}}
@extends('layouts.dashboard')

@section('title', 'Detail Berita Acara Serah Terima')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/verifikasi.css') }}">
@endpush

@section('content')
<x-page-header
    title="Berita Acara Serah Terima"
    subtitle="Detail pencatatan resmi serah terima barang di lingkungan FMIPA UHO"
    :breadcrumbs="[
        ['label' => 'Serah Terima', 'url' => route('verification.handover.index')],
        ['label' => 'Detail #' . $handover->id]
    ]"
>
    <x-slot:actions>
        <a href="{{ route('verification.handover.index') }}" class="btn btn-sm btn-outline-secondary">
            ← Kembali ke Daftar
        </a>
    </x-slot:actions>
</x-page-header>

<div class="detail-grid">
    {{-- Kolom Kiri: Informasi Barang --}}
    <div class="detail-media-card">
        <div class="detail-image-wrapper">
            @if ($handover->item->photo)
                <img src="{{ asset('storage/' . $handover->item->photo) }}" alt="{{ $handover->item->name }}">
            @else
                <div class="detail-image-placeholder">📦</div>
            @endif
        </div>

        <div class="detail-summary-body">
            <div class="detail-code">Laporan: {{ $handover->item->kode }}</div>
            <h2 class="detail-item-title">{{ $handover->item->name }}</h2>

            <div style="margin-bottom: 1rem; display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                <x-type-badge :type="$handover->item->type" />
                <x-status-badge :status="$handover->item->status" />
            </div>

            <div class="info-list">
                <div class="info-row">
                    <span class="info-label">Kategori</span>
                    <span class="info-value">{{ $handover->item->category?->name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Lokasi Kejadian</span>
                    <span class="info-value">📍 {{ $handover->item->location }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Kejadian</span>
                    <span class="info-value">{{ $handover->item->incident_date?->format('d M Y') ?? '-' }}</span>
                </div>
            </div>

            <div style="margin-top: 1rem;">
                <span style="font-size: 0.85rem; font-weight: 600; color: var(--text-dark); display: block; margin-bottom: 0.25rem;">
                    Deskripsi Barang:
                </span>
                <p style="font-size: 0.875rem; color: var(--text-muted); line-height: 1.5; background: #FAF8F5; padding: 0.75rem; border-radius: 4px;">
                    {{ $handover->item->description }}
                </p>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Rincian Berita Acara, Penerima & Petugas --}}
    <div class="detail-content-card">
        {{-- Data Penerima Sah --}}
        <div class="section-box">
            <h3 class="section-title">👤 Penerima Barang (Pemilik Sah)</h3>
            <div class="user-identity-box">
                <div class="user-avatar-circle" style="background-color: var(--yellow); color: var(--text-dark);">
                    {{ strtoupper(substr($handover->receiver->name, 0, 1)) }}
                </div>
                <div class="user-identity-info">
                    <h4>{{ $handover->receiver->name }}</h4>
                    <p>NIM: <strong>{{ $handover->receiver->nim ?? '-' }}</strong> &bull; Email: {{ $handover->receiver->email }}</p>
                    <p style="margin-top: 0.25rem; font-size: 0.8rem; color: var(--text-muted);">
                        Peran Akun: <strong>{{ ucfirst($handover->receiver->role) }}</strong>
                    </p>
                </div>
            </div>
        </div>

        {{-- Petugas Pencatat & Waktu Serah Terima --}}
        <div class="section-box">
            <h3 class="section-title">🛡️ Petugas Pemeriksa &amp; Pencatat</h3>
            <div class="info-list" style="border-top: none; margin-top: 0; padding-top: 0;">
                <div class="info-row">
                    <span class="info-label">Nama Petugas</span>
                    <span class="info-value">{{ $handover->officer->name }} ({{ $handover->officer->email }})</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Waktu Serah Terima</span>
                    <span class="info-value">
                        📅 {{ ($handover->handover_date ?? $handover->handed_over_at)?->translatedFormat('d F Y, H:i') ?? '-' }} WITA
                    </span>
                </div>
                @if ($handover->claim)
                    <div class="info-row">
                        <span class="info-label">Dasar Pengajuan Klaim</span>
                        <span class="info-value">{{ $handover->claim->kode }} (<x-status-badge :status="$handover->claim->status" />)</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Catatan Berita Acara --}}
        <div class="section-box">
            <h3 class="section-title">📝 Catatan Berita Acara Serah Terima</h3>
            <div class="section-text" style="font-size: 0.95rem; line-height: 1.6; background-color: #F8FAFC; border: 1px solid var(--border); padding: 16px; border-radius: 8px;">
                {{ $handover->notes ?? ($handover->return_note ?? 'Barang telah dicocokkan identitas dan diserahterimakan kepada pemilik yang sah dalam kondisi baik.') }}
            </div>
        </div>

        {{-- Bukti Klaim Jika Ada --}}
        @if ($handover->claim && $handover->claim->proof)
            <div class="section-box">
                <h3 class="section-title">📎 Berkas Bukti Dasar Verifikasi</h3>
                <div class="evidence-box">
                    <div class="evidence-info">
                        <span>📄</span>
                        <span>Berkas Bukti Terverifikasi ({{ basename($handover->claim->proof) }})</span>
                    </div>
                    <a href="{{ route('claims.evidence', $handover->claim) }}" target="_blank" class="btn btn-sm btn-yellow">
                        👁️ Buka Bukti
                    </a>
                </div>
            </div>
        @endif

        <div style="margin-top: 1.5rem; text-align: right;">
            <a href="{{ route('verification.handover.index') }}" class="btn btn-primary">
                ✓ Selesai &amp; Kembali
            </a>
        </div>
    </div>
</div>
{{-- [/M6-VERIFIKASI] --}}
@endsection

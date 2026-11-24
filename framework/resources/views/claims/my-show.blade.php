@extends('layouts.dashboard')

@section('title', 'Detail Pengajuan - FMIPA Lost & Found')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/klaim.css') }}">
@endpush

@section('dashboard')
@php
    $claimKode = $claim->kode ?? ('KLM-' . str_pad($claim->id, 3, '0', STR_PAD_LEFT));
    $itemKode = $claim->item->kode ?? (($claim->item->type === 'found' ? 'FND-' : 'LST-') . str_pad($claim->item_id, 3, '0', STR_PAD_LEFT));
    $isKlaim = $claim->type === (defined('\App\Models\Claim::TYPE_KLAIM') ? \App\Models\Claim::TYPE_KLAIM : 'klaim');
    $statusLower = strtolower($claim->status);
    $handover = $claim->item->handoverRecord ?? null;
@endphp

<div class="my-claims-container">
    {{-- Header Breadcrumb & Judul --}}
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <div>
            <a href="{{ route('my-claims.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem; color: var(--klaim-maroon); text-decoration: none; font-weight: 500; margin-bottom: 6px;">
                &larr; Kembali ke Riwayat Klaim
            </a>
            <h1 class="my-claims-title">Detail Pengajuan: {{ $claimKode }}</h1>
            <p class="my-claims-subtitle">Rincian status verifikasi dan data yang Anda kirimkan.</p>
        </div>
        <div>
            @if ($statusLower === 'diterima')
                <span class="badge-status-klaim badge-status-diterima" style="font-size: 0.875rem; padding: 6px 14px;">
                    ● Status: Diterima
                </span>
            @elseif ($statusLower === 'ditolak')
                <span class="badge-status-klaim badge-status-ditolak" style="font-size: 0.875rem; padding: 6px 14px;">
                    ● Status: Ditolak
                </span>
            @else
                <span class="badge-status-klaim badge-status-diajukan" style="font-size: 0.875rem; padding: 6px 14px;">
                    ● Status: Menunggu Pemeriksaan
                </span>
            @endif
        </div>
    </div>

    {{-- Stepper Perkembangan Klaim Anda (Sesuai Figma Hal. 3) --}}
    @if (view()->exists('components.claim-stepper'))
        <x-claim-stepper :claim="$claim" />
    @else
        {{-- Fallback Stepper 4 Langkah Sesuai Desain Figma Hal. 3 & Subbab 3.3 Butir 2 --}}
        <div class="claim-stepper-card">
            <div class="claim-stepper-head">
                <h3 class="claim-stepper-title">Perkembangan Klaim Anda</h3>
                <span class="badge-type-tag" style="background-color: var(--klaim-cream); color: var(--klaim-maroon); font-weight: 600;">
                    {{ $claimKode }} &bull; {{ $claim->item->name }}
                </span>
            </div>
            <p class="claim-stepper-sub">
                @if ($statusLower === 'ditolak')
                    Mohon maaf, pengajuan Anda tidak dapat diverifikasi karena bukti atau ciri khusus tidak cocok dengan barang.
                @elseif ($handover)
                    Barang telah diserahterimakan secara sah kepada pemilik.
                @elseif ($statusLower === 'diterima')
                    Bukti Anda telah diverifikasi dan disetujui. Silakan datangi petugas kampus untuk proses serah terima.
                @else
                    Bukti Anda sudah diterima sistem dan saat ini sedang diperiksa dan dicocokkan oleh petugas kampus.
                @endif
            </p>

            <div class="claim-stepper-track">
                <div class="claim-step-connector">
                    <div class="claim-step-connector-fill" style="width: {{ $handover ? '100%' : ($statusLower === 'diterima' ? '66%' : ($statusLower === 'ditolak' ? '66%' : '33%')) }};"></div>
                </div>

                {{-- Langkah 1: Diajukan --}}
                <div class="claim-step-node completed">
                    <div class="claim-step-circle">✓</div>
                    <span class="claim-step-label">Diajukan</span>
                    <span class="claim-step-date">{{ $claim->created_at ? $claim->created_at->translatedFormat('d M Y') : '-' }}</span>
                </div>

                {{-- Langkah 2: Diperiksa --}}
                <div class="claim-step-node {{ $statusLower === 'ditolak' ? 'completed' : ($statusLower === 'diterima' || $handover ? 'completed' : 'active') }}">
                    <div class="claim-step-circle">
                        @if ($statusLower === 'diterima' || $handover || $statusLower === 'ditolak') ✓ @else 2 @endif
                    </div>
                    <span class="claim-step-label">Diperiksa</span>
                    <span class="claim-step-date">
                        @if ($claim->verified_at)
                            {{ $claim->verified_at->translatedFormat('d M Y') }}
                        @else
                            Sedang diproses
                        @endif
                    </span>
                </div>

                {{-- Langkah 3: Disetujui / Ditolak --}}
                @if ($statusLower === 'ditolak')
                    <div class="claim-step-node rejected">
                        <div class="claim-step-circle">✕</div>
                        <span class="claim-step-label" style="color: #dc2626;">Ditolak</span>
                        <span class="claim-step-date">{{ $claim->verified_at ? $claim->verified_at->translatedFormat('d M Y') : 'Hasil verifikasi' }}</span>
                    </div>
                @else
                    <div class="claim-step-node {{ $statusLower === 'diterima' || $handover ? 'completed' : '' }}">
                        <div class="claim-step-circle">
                            @if ($statusLower === 'diterima' || $handover) ✓ @else 3 @endif
                        </div>
                        <span class="claim-step-label">Disetujui</span>
                        <span class="claim-step-date">{{ $claim->verified_at ? $claim->verified_at->translatedFormat('d M Y') : 'Menunggu hasil' }}</span>
                    </div>
                @endif

                {{-- Langkah 4: Diserahkan --}}
                <div class="claim-step-node {{ $handover ? 'completed' : '' }}">
                    <div class="claim-step-circle">
                        @if ($handover) ✓ @else 4 @endif
                    </div>
                    <span class="claim-step-label">Diserahkan</span>
                    <span class="claim-step-date">{{ $handover ? \Carbon\Carbon::parse($handover->handed_over_at)->translatedFormat('d M Y') : 'Setelah disetujui' }}</span>
                </div>
            </div>
        </div>
    @endif

    {{-- Grid Detail Informasi --}}
    <div class="claim-detail-grid">
        {{-- Kolom Kiri: Isian Pengajuan & Hasil Verifikasi --}}
        <div>
            {{-- Kartu Isian Pengaju --}}
            <div class="claim-info-card">
                <h2 class="claim-info-card-title">
                    {{ $isKlaim ? 'Rincian Bukti & Ciri Kepemilikan' : 'Rincian Pelaporan Penemuan' }}
                </h2>

                <dl class="claim-dl">
                    <dt>Jenis Pengajuan</dt>
                    <dd>
                        <strong>{{ $isKlaim ? 'Klaim Kepemilikan (Laporan Found)' : 'Pelaporan Penemuan (Laporan Lost)' }}</strong>
                    </dd>

                    <dt>Waktu Kirim</dt>
                    <dd>{{ $claim->created_at ? $claim->created_at->translatedFormat('d F Y, H:i WITA') : '-' }}</dd>

                    @if ($isKlaim)
                        <dt>Deskripsi Ciri Khusus</dt>
                        <dd style="white-space: pre-line; line-height: 1.6; background: #fbfbfc; padding: 10px 14px; border-radius: 6px; border: 1px solid #f1f5f9;">
                            {{ $claim->ownership_description }}
                        </dd>
                    @else
                        <dt>Kondisi &amp; Ciri Barang</dt>
                        <dd style="white-space: pre-line; line-height: 1.6; background: #fbfbfc; padding: 10px 14px; border-radius: 6px; border: 1px solid #f1f5f9;">
                            {{ $claim->finding_description }}
                        </dd>

                        <dt>Lokasi Ditemukan</dt>
                        <dd>{{ $claim->finding_location }}</dd>

                        <dt>Waktu Ditemukan</dt>
                        <dd>{{ $claim->finding_time ? \Carbon\Carbon::parse($claim->finding_time)->translatedFormat('d F Y, H:i WITA') : '-' }}</dd>

                        <dt>Lokasi Penyimpanan</dt>
                        <dd>{{ $claim->storage_location }}</dd>
                    @endif
                </dl>

                {{-- Box Bukti Foto / Dokumen (NFR-05) --}}
                <div class="claim-evidence-box">
                    <div>
                        <strong style="display: block; font-size: 0.9rem; color: var(--klaim-maroon);">
                            🔒 Berkas Bukti Terlampir
                        </strong>
                        <span style="font-size: 0.775rem; color: var(--klaim-text-muted);">
                            Bukti ini disimpan privat dan hanya dapat dibuka oleh Anda serta petugas verifikator.
                        </span>
                    </div>
                    <a href="{{ route('claims.evidence', $claim) }}" target="_blank" rel="noopener noreferrer" class="btn-view-evidence">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        Buka Bukti
                    </a>
                </div>
            </div>

            {{-- Kartu Hasil Pemeriksaan / Verifikasi Petugas --}}
            <div class="claim-info-card">
                <h2 class="claim-info-card-title">Hasil Pemeriksaan Petugas</h2>
                <dl class="claim-dl">
                    <dt>Status</dt>
                    <dd>
                        @switch($statusLower)
                            @case('diterima')
                                <span class="badge-status-klaim badge-status-diterima">● Diterima</span>
                                @break
                            @case('ditolak')
                                <span class="badge-status-klaim badge-status-ditolak">● Ditolak</span>
                                @break
                            @default
                                <span class="badge-status-klaim badge-status-diajukan">● Sedang Diperiksa</span>
                        @endswitch
                    </dd>

                    <dt>Petugas Pemeriksa</dt>
                    <dd>{{ $claim->verifier->name ?? 'Belum ditugaskan / dalam antrean' }}</dd>

                    <dt>Waktu Verifikasi</dt>
                    <dd>{{ $claim->verified_at ? \Carbon\Carbon::parse($claim->verified_at)->translatedFormat('d F Y, H:i WITA') : 'Menunggu giliran pemeriksaan' }}</dd>
                </dl>
            </div>

            {{-- Kartu Serah Terima (Jika Ada Handover Record) --}}
            @if ($handover)
                <div class="claim-info-card" style="border-left: 4px solid #16a34a;">
                    <h2 class="claim-info-card-title" style="color: #166534;">Catatan Serah Terima Resmi</h2>
                    <dl class="claim-dl">
                        <dt>Tanggal Penyerahan</dt>
                        <dd>{{ \Carbon\Carbon::parse($handover->handed_over_at)->translatedFormat('d F Y, H:i WITA') }}</dd>

                        <dt>Petugas Kampus</dt>
                        <dd>{{ $handover->officer->name ?? '-' }}</dd>

                        <dt>Penerima Barang</dt>
                        <dd>{{ $handover->receiver->name ?? '-' }}</dd>

                        <dt>Catatan</dt>
                        <dd>{{ $handover->return_note ?? 'Barang telah diterima dalam kondisi baik.' }}</dd>
                    </dl>
                </div>
            @endif
        </div>

        {{-- Kolom Kanan: Ringkasan Barang --}}
        <div>
            <div class="claim-info-card">
                <h2 class="claim-info-card-title">Informasi Barang Terkait</h2>
                @php
                    $photoUrl = !empty($claim->item->photo) ? asset('storage/' . $claim->item->photo) : asset('images/placeholder-item.png');
                @endphp
                <img src="{{ $photoUrl }}" alt="{{ $claim->item->name }}" style="width: 100%; height: 160px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 14px;" onerror="this.src='https://placehold.co/300x160?text=Barang';">
                
                <div style="margin-bottom: 12px;">
                    <span class="item-summary-code">{{ $itemKode }}</span>
                    <h3 style="font-family: var(--klaim-font-heading); font-size: 1.15rem; color: var(--klaim-maroon); margin: 4px 0;">
                        {{ $claim->item->name }}
                    </h3>
                </div>

                <dl class="claim-dl" style="font-size: 0.825rem; grid-template-columns: 100px 1fr;">
                    <dt>Tipe Laporan</dt>
                    <dd>{{ $claim->item->type === 'found' ? 'Barang Ditemukan' : 'Barang Hilang' }}</dd>

                    <dt>Kategori</dt>
                    <dd>{{ $claim->item->category->name ?? 'Umum' }}</dd>

                    <dt>Lokasi</dt>
                    <dd>{{ $claim->item->location }}</dd>

                    <dt>Waktu Kejadian</dt>
                    <dd>{{ $claim->item->incident_date ? \Carbon\Carbon::parse($claim->item->incident_date)->translatedFormat('d M Y') : '-' }}</dd>
                </dl>

                <div style="margin-top: 18px; pt-3; border-top: 1px solid #f1f5f9;">
                    <a href="{{ route('items.show', $claim->item) }}" class="btn-claim-action btn-claim-yellow" style="font-size: 0.85rem; padding: 10px 14px;">
                        Lihat Laporan Barang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

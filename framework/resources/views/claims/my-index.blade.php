@extends('layouts.dashboard')

@section('title', 'Klaim Saya - FMIPA Lost & Found')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/klaim.css') }}">
@endpush

@section('dashboard')
<div class="my-claims-container">
    {{-- Header Halaman --}}
    <div class="my-claims-header">
        <h1 class="my-claims-title">Riwayat Klaim Saya</h1>
        <p class="my-claims-subtitle">
            Pantau status dan perkembangan seluruh pengajuan klaim kepemilikan maupun pelaporan penemuan barang Anda.
        </p>
    </div>

    {{-- Kartu Tabel Riwayat Klaim (Sesuai Gaya Figma Hal. 3) --}}
    <div class="claims-table-card">
        @if ($claims->isEmpty())
            <div style="padding: 48px 24px; text-align: center;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 12px;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
                <h3 style="font-family: var(--klaim-font-heading); font-size: 1.2rem; color: var(--klaim-maroon); margin: 0 0 6px 0;">Belum Ada Pengajuan</h3>
                <p style="font-family: var(--klaim-font-body); font-size: 0.875rem; color: var(--klaim-text-muted); max-width: 420px; margin: 0 auto 18px auto;">
                    Anda belum pernah mengajukan klaim kepemilikan atau melaporkan penemuan barang hilang.
                </p>
                <a href="{{ route('items.index') }}" class="btn-claim-action btn-claim-yellow" style="display: inline-flex; width: auto; padding: 10px 20px;">
                    Cari Barang di Katalog
                </a>
            </div>
        @else
            <div class="claims-table-responsive">
                <table class="claims-table">
                    <thead>
                        <tr>
                            <th>Klaim / Barang</th>
                            <th>Laporan / Kategori</th>
                            <th>Jenis Pengajuan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th style="text-align: center;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($claims as $claim)
                            @php
                                $claimKode = $claim->kode ?? ('KLM-' . str_pad($claim->id, 3, '0', STR_PAD_LEFT));
                                $itemKode = $claim->item->kode ?? (($claim->item->type === 'found' ? 'FND-' : 'LST-') . str_pad($claim->item_id, 3, '0', STR_PAD_LEFT));
                                $isKlaim = $claim->type === (defined('\App\Models\Claim::TYPE_KLAIM') ? \App\Models\Claim::TYPE_KLAIM : 'klaim');
                            @endphp
                            <tr>
                                <td>
                                    <span class="claim-code-cell">{{ $claimKode }}</span>
                                    <span class="claim-item-title">{{ $claim->item->name ?? 'Barang #' . $claim->item_id }}</span>
                                </td>
                                <td>
                                    <span style="font-weight: 500; color: #475569;">{{ $itemKode }}</span>
                                    <span class="claim-item-sub">&bull; {{ $claim->item->category->name ?? 'Umum' }}</span>
                                </td>
                                <td>
                                    @if ($isKlaim)
                                        <span class="badge-type-tag" style="background-color: #fef2f2; color: #991b1b; font-weight: 600;">Klaim Kepemilikan</span>
                                    @else
                                        <span class="badge-type-tag" style="background-color: #fefce8; color: #854d0e; font-weight: 600;">Laporan Penemuan</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $claim->created_at ? $claim->created_at->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td>
                                    {{-- Menggunakan komponen x-status-badge jika ada, atau fallback badge terstandar --}}
                                    @if (view()->exists('components.status-badge'))
                                        <x-status-badge :status="$claim->status" />
                                    @else
                                        @switch(strtolower($claim->status))
                                            @case('diterima')
                                                <span class="badge-status-klaim badge-status-diterima">
                                                    ● Diterima
                                                </span>
                                                @break
                                            @case('ditolak')
                                                <span class="badge-status-klaim badge-status-ditolak">
                                                    ● Ditolak
                                                </span>
                                                @break
                                            @default
                                                <span class="badge-status-klaim badge-status-diajukan">
                                                    ● Diajukan
                                                </span>
                                        @endswitch
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('my-claims.show', $claim) }}" class="claim-btn-detail">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($claims->hasPages())
                <div class="claims-pagination-bar">
                    {{ $claims->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

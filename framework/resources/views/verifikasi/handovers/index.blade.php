@extends('layouts.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/verifikasi.css') }}">
@endpush

@section('dashboard')
    <x-page-header 
        title="Pencatatan Serah Terima Barang" 
        subtitle="Daftar pengajuan berstatus diterima yang siap diserahterimakan kepada pemilik yang sah."
    />

    <div class="card">
        @if ($claims->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode Pengajuan</th>
                            <th>Barang Terkait</th>
                            <th>Penerima yang Sah</th>
                            <th>Jenis Pengajuan</th>
                            <th>Waktu Verifikasi</th>
                            <th>Status Barang</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($claims as $claim)
                            @php
                                // Aturan Penerima yang Sah:
                                // Laporan Found -> pengaju klaim (claim.submitter)
                                // Laporan Lost  -> pembuat laporan Lost (item.user)
                                $receiver = $claim->item->type === \App\Models\Item::TYPE_FOUND 
                                    ? $claim->submitter 
                                    : $claim->item->user;
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $claim->kode }}</strong><br>
                                    <x-status-badge :status="$claim->status" />
                                </td>
                                <td>
                                    <strong>{{ $claim->item->kode }}</strong> - {{ $claim->item->name }}<br>
                                    <small style="color: var(--text-muted);">
                                        Tipe: <x-type-badge :type="$claim->item->type" /> &bull; 📍 {{ $claim->item->location }}
                                    </small>
                                </td>
                                <td>
                                    <strong>{{ $receiver->name }}</strong><br>
                                    <small style="color: var(--text-muted);">NIM: {{ $receiver->nim ?? '-' }}</small><br>
                                    <small style="color: var(--maroon); font-weight: 500;">
                                        ({{ $claim->item->type === \App\Models\Item::TYPE_FOUND ? 'Pengaju Klaim' : 'Pembuat Laporan Lost' }})
                                    </small>
                                </td>
                                <td>
                                    <x-type-badge :type="$claim->type" />
                                </td>
                                <td>
                                    {{ $claim->verified_at ? $claim->verified_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td>
                                    <x-status-badge :status="$claim->item->status" />
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ route('handovers.create', $claim) }}" class="btn btn-sm btn-yellow">
                                        🤝 Proses Serah Terima
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $claims->links() }}
            </div>
        @else
            <x-empty-state 
                title="Tidak Ada Antrean Serah Terima" 
                message="Belum ada pengajuan berstatus diterima yang menunggu serah terima barang."
            />
        @endif
    </div>
@endsection

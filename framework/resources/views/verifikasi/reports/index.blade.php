@extends('layouts.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/verifikasi.css') }}">
@endpush

@section('dashboard')
    <x-page-header 
        title="Verifikasi Laporan" 
        subtitle="Daftar laporan barang hilang dan ditemukan yang menunggu pemeriksaan admin."
    />

    <div class="card">
        @if ($reports->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode &amp; Nama Barang</th>
                            <th>Jenis &amp; Kategori</th>
                            <th>Lokasi Kejadian</th>
                            <th>Tanggal Lapor</th>
                            <th>Pelapor</th>
                            <th>Status</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <td>
                                    <strong>{{ $report->kode }}</strong><br>
                                    <span style="color: var(--text-dark);">{{ $report->name }}</span>
                                </td>
                                <td>
                                    <x-type-badge :type="$report->type" /><br>
                                    <small style="color: var(--text-muted);">{{ $report->category?->name ?? '-' }}</small>
                                </td>
                                <td>
                                    <span>📍 {{ $report->location }}</span>
                                </td>
                                <td>
                                    {{ $report->created_at->format('d M Y, H:i') }}
                                </td>
                                <td>
                                    <span>{{ $report->user->name }}</span><br>
                                    <small style="color: var(--text-muted);">NIM: {{ $report->user->nim ?? '-' }}</small>
                                </td>
                                <td>
                                    <x-status-badge :status="$report->status" />
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ route('verifikasi.reports.show', $report) }}" class="btn btn-sm btn-primary">
                                        Periksa Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $reports->links() }}
            </div>
        @else
            <x-empty-state 
                title="Tidak Ada Laporan Menunggu" 
                message="Semua laporan barang telah diverifikasi oleh admin. Tidak ada antrean verifikasi saat ini."
            />
        @endif
    </div>
@endsection

@extends('layouts.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/verifikasi.css') }}">
@endpush

@section('dashboard')
    <x-page-header 
        title="Verifikasi Pengajuan (Klaim &amp; Penemuan)" 
        subtitle="Daftar pengajuan klaim kepemilikan dan laporan penemuan yang diajukan oleh pengguna."
    />

    <div class="card">
        {{-- Filter Bar --}}
        <div class="filter-bar">
            <form method="GET" action="{{ route('verifikasi.claims.index') }}" class="filter-group">
                <label for="typeFilter" style="font-size: 0.875rem; font-weight: 600; color: var(--text-dark);">
                    Filter Jenis:
                </label>
                <select name="type" id="typeFilter" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Jenis Pengajuan</option>
                    <option value="{{ \App\Models\Claim::TYPE_KLAIM }}" {{ request('type') === \App\Models\Claim::TYPE_KLAIM ? 'selected' : '' }}>
                        Klaim Kepemilikan (Laporan Found)
                    </option>
                    <option value="{{ \App\Models\Claim::TYPE_PENEMUAN }}" {{ request('type') === \App\Models\Claim::TYPE_PENEMUAN ? 'selected' : '' }}>
                        Laporan Penemuan (Laporan Lost)
                    </option>
                </select>
                @if (request('type'))
                    <a href="{{ route('verifikasi.claims.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                @endif
            </form>

            <span style="font-size: 0.85rem; color: var(--text-muted);">
                Total: <strong>{{ $claims->total() }}</strong> pengajuan diajukan
            </span>
        </div>

        @if ($claims->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode Pengajuan</th>
                            <th>Barang Terkait</th>
                            <th>Pengaju</th>
                            <th>Jenis Pengajuan</th>
                            <th>Waktu Masuk</th>
                            <th>Status</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($claims as $claim)
                            <tr>
                                <td>
                                    <strong>{{ $claim->kode }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $claim->item->kode }}</strong> - {{ $claim->item->name }}<br>
                                    <small style="color: var(--text-muted);">
                                        Tipe Laporan: <x-type-badge :type="$claim->item->type" />
                                    </small>
                                </td>
                                <td>
                                    <span>{{ $claim->submitter->name }}</span><br>
                                    <small style="color: var(--text-muted);">NIM: {{ $claim->submitter->nim ?? '-' }}</small>
                                </td>
                                <td>
                                    <x-type-badge :type="$claim->type" />
                                </td>
                                <td>
                                    {{ $claim->created_at->format('d M Y, H:i') }}
                                </td>
                                <td>
                                    <x-status-badge :status="$claim->status" />
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ route('verifikasi.claims.show', $claim) }}" class="btn btn-sm btn-primary">
                                        Periksa Pengajuan
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
                title="Tidak Ada Pengajuan Menunggu" 
                message="Saat ini tidak ada klaim atau laporan penemuan berstatus diajukan yang perlu diverifikasi."
            />
        @endif
    </div>
@endsection

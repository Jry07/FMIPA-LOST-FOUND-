@extends('layouts.dashboard')

@section('title', 'Laporan Saya - FMIPA Lost & Found')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/laporan-dashboard.css') }}">
@endpush

@section('content')
<div class="my-reports-wrapper">
    {{-- Header --}}
    <div class="dashboard-page-header">
        <div>
            <div class="dashboard-pretitle">PENGELOLAAN LAPORAN</div>
            <h1 class="dashboard-title">Laporan Saya</h1>
            <p class="dashboard-subtitle">Kelola dan pantau status laporan barang hilang dan temuan milik Anda.</p>
        </div>
        <div>
            <a href="{{ route('reports.create') }}" class="btn-m3-primary">
                Buat Laporan Baru +
            </a>
        </div>
    </div>

    @if (session('success'))
        <div style="background-color: #DCFCE7; border: 1px solid #86EFAC; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background-color: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Laporan Saya --}}
    <div class="history-section-card">
        @if ($reports->isNotEmpty())
            <div class="table-responsive">
                <table class="m3-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Barang</th>
                            <th>Jenis</th>
                            <th>Lokasi & Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->kode ?? ('LST-' . str_pad($item->id, 3, '0', STR_PAD_LEFT)) }}</strong>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        @if ($item->photo)
                                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}"
                                                 style="width: 44px; height: 44px; object-fit: cover; border-radius: 6px; border: 1px solid #E5E7EB;">
                                        @else
                                            <div style="width: 44px; height: 44px; border-radius: 6px; background-color: #F3F4F6; display: flex; align-items: center; justify-content: center; color: #9CA3AF;">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                    <polyline points="21 15 16 10 5 21"></polyline>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight: 600; color: #1F2937;">{{ $item->name }}</div>
                                            <div style="font-size: 12px; color: #6B7280;">{{ $item->category->name ?? 'Umum' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($item->type === 'lost')
                                        <span style="display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; background-color: #FEE2E2; color: #991B1B;">Hilang</span>
                                    @else
                                        <span style="display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; background-color: #DBEAFE; color: #1E40AF;">Ditemukan</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="color: #374151;">{{ $item->location }}</div>
                                    <div style="font-size: 11px; color: #6B7280;">{{ \Carbon\Carbon::parse($item->incident_date)->translatedFormat('d F Y') }}</div>
                                </td>
                                <td>
                                    <x-status-badge :status="$item->status" />
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                        {{-- Jika status Menunggu: Tombol Ubah & Batalkan --}}
                                        @if ($item->status === (defined('App\Models\Item::STATUS_MENUNGGU') ? \App\Models\Item::STATUS_MENUNGGU : 'menunggu'))
                                            <a href="{{ route('my-reports.edit', $item) }}" class="btn-m3-outline" style="padding: 6px 12px; font-size: 12px;">
                                                Ubah
                                            </a>
                                            <form action="{{ route('my-reports.cancel', $item) }}" method="POST" class="form-cancel-report" style="margin: 0;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-m3-danger-outline">
                                                    Batalkan
                                                </button>
                                            </form>

                                        {{-- Jika status Dipublikasikan: Tombol Detail & Batalkan --}}
                                        @elseif ($item->status === (defined('App\Models\Item::STATUS_DIPUBLIKASIKAN') ? \App\Models\Item::STATUS_DIPUBLIKASIKAN : 'dipublikasikan'))
                                            <a href="{{ route('items.show', $item) }}" class="btn-m3-outline" style="padding: 6px 12px; font-size: 12px;">
                                                Detail
                                            </a>
                                            <form action="{{ route('my-reports.cancel', $item) }}" method="POST" class="form-cancel-report" style="margin: 0;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-m3-danger-outline">
                                                    Batalkan
                                                </button>
                                            </form>

                                        {{-- Status Lainnya (Selesai, Ditolak, Dibatalkan): Hanya Tombol Detail --}}
                                        @else
                                            <a href="{{ route('items.show', $item) }}" class="btn-m3-outline" style="padding: 6px 12px; font-size: 12px;">
                                                Detail
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px;">
                {{ $reports->links() }}
            </div>
        @else
            <x-empty-state message="Anda belum pernah membuat laporan barang." action-text="Buat Laporan Sekarang" :action-url="route('reports.create')" />
        @endif
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/laporan.js') }}"></script>
@endpush

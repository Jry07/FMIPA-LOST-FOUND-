@extends('layouts.dashboard')
@section('title', 'Log Riwayat Status - Admin')
@section('page_title', 'Log Riwayat Status Barang')
@section('content')
{{-- [M1-ADMIN] --}}
<x-page-header title="Riwayat Perubahan Status" description="Rekam jejak lengkap seluruh perubahan status laporan barang" />
<div class="table-responsive">
    <table class="table-custom">
        <thead>
            <tr><th>Waktu</th><th>Barang</th><th>Status Lama</th><th>Status Baru</th><th>Oleh</th><th>Catatan</th></tr>
        </thead>
        <tbody>
            @foreach(\App\Models\ItemStatusHistory::with(['item','user'])->latest()->take(50)->get() as $log)
            <tr>
                <td style="font-size:0.82rem;color:var(--gray);">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('catalog.show', $log->item_id) }}" style="font-weight:600;">{{ $log->item->name ?? '-' }}</a>
                </td>
                <td>
                    @if($log->previous_status)
                        <x-status-badge :status="$log->previous_status" />
                    @else
                        <span style="color:var(--gray);font-style:italic;">Baru dibuat</span>
                    @endif
                </td>
                <td><x-status-badge :status="$log->new_status" /></td>
                <td>{{ $log->user->name ?? 'Sistem' }}</td>
                <td style="font-size:0.85rem;color:var(--gray);">{{ $log->notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- [/M1-ADMIN] --}}
@endsection

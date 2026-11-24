{{-- [M5-KLAIM] --}}
@extends('layouts.dashboard')

@section('title', 'Detail Klaim #' . $claim->kode)

@section('content')
<x-page-header
    title="Detail Klaim {{ $claim->kode }}"
    subtitle="Informasi lengkap pengajuan klaim barang"
/>

<x-claim-stepper :claim="$claim" />

<div class="row mt-4">
    {{-- Info Klaim --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Klaim</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Kode Klaim</th>
                        <td>{{ $claim->kode }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Klaim</th>
                        <td><x-type-badge :type="$claim->type" /></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><x-status-badge :status="$claim->status" /></td>
                    </tr>
                    <tr>
                        <th>Pengaju</th>
                        <td>{{ $claim->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td>{{ $claim->created_at->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $claim->description ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Info Barang --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Barang Terkait</h5>
            </div>
            <div class="card-body">
                <x-item-card :item="$claim->item" />
            </div>
        </div>
    </div>
</div>

{{-- Tombol Aksi (diisi oleh M5) --}}
@include('claims.partials.action-button', ['claim' => $claim])

{{-- Langkah Info (diisi oleh M5) --}}
@include('claims.partials.info-steps', ['claim' => $claim])
{{-- [/M5-KLAIM] --}}
@endsection

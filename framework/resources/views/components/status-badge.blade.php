@props(['status'])

@php
    $statusClass = match (strtolower($status)) {
        'menunggu', 'menunggu_verifikasi' => 'badge-status-menunggu',
        'dipublikasikan', 'diterima' => 'badge-status-dipublikasikan',
        'selesai' => 'badge-status-selesai',
        'ditolak' => 'badge-status-ditolak',
        'dibatalkan' => 'badge-status-dibatalkan',
        'diajukan' => 'badge-status-diajukan',
        default => 'badge-status-default',
    };

    $label = match (strtolower($status)) {
        'menunggu', 'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'dipublikasikan' => 'Dipublikasikan',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
        'dibatalkan' => 'Dibatalkan',
        'diajukan' => 'Diajukan',
        'diterima' => 'Diterima',
        default => ucfirst($status),
    };
@endphp

<span {{ $attributes->merge(['class' => 'badge ' . $statusClass]) }}>
    {{ $label }}
</span>

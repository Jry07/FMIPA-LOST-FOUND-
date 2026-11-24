@props(['status'])

@php
    $statusNormalized = strtolower($status ?? '');
    $badgeClasses = match($statusNormalized) {
        'menunggu', 'menunggu verifikasi', 'diajukan' => 'badge-warning',
        'dipublikasikan', 'diterima' => 'badge-success',
        'selesai' => 'badge-primary',
        'ditolak' => 'badge-danger',
        'dibatalkan' => 'badge-muted',
        default => 'badge-default',
    };

    $label = match($statusNormalized) {
        'menunggu' => 'Menunggu Verifikasi',
        'dipublikasikan' => 'Dipublikasikan',
        'ditolak' => 'Ditolak',
        'dibatalkan' => 'Dibatalkan',
        'selesai' => 'Selesai',
        'diajukan' => 'Diajukan',
        'diterima' => 'Diterima',
        default => ucfirst($status),
    };
@endphp

<span class="badge {{ $badgeClasses }}">
    {{ $label }}
</span>

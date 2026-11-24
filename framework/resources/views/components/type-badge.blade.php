@props(['type'])

@php
    $typeNormalized = strtolower($type ?? '');
    $badgeClasses = match($typeNormalized) {
        'lost', 'hilang' => 'type-badge-lost',
        'found', 'ditemukan' => 'type-badge-found',
        'klaim' => 'type-badge-claim',
        'penemuan' => 'type-badge-found-report',
        default => 'type-badge-default',
    };

    $label = match($typeNormalized) {
        'lost' => 'Kehilangan',
        'found' => 'Ditemukan',
        'klaim' => 'Klaim Kepemilikan',
        'penemuan' => 'Laporan Penemuan',
        default => ucfirst($type),
    };
@endphp

<span class="type-badge {{ $badgeClasses }}">
    {{ $label }}
</span>

@props(['type'])

@php
    $typeClass = match (strtolower($type)) {
        'lost' => 'badge-type-lost',
        'found' => 'badge-type-found',
        'klaim' => 'badge-type-klaim',
        'penemuan' => 'badge-type-penemuan',
        default => 'badge-type-default',
    };

    $label = match (strtolower($type)) {
        'lost' => 'Barang Hilang',
        'found' => 'Barang Ditemukan',
        'klaim' => 'Klaim Kepemilikan',
        'penemuan' => 'Pelaporan Penemuan',
        default => strtoupper($type),
    };
@endphp

<span {{ $attributes->merge(['class' => 'badge ' . $typeClass]) }}>
    {{ $label }}
</span>

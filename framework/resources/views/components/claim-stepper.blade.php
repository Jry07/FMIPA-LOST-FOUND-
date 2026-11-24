@props(['status', 'type' => 'klaim'])

@php
    $steps = [
        ['key' => 'diajukan', 'label' => 'Diajukan', 'desc' => 'Pengajuan terkirim'],
        ['key' => 'diperiksa', 'label' => 'Diperiksa', 'desc' => 'Menunggu hasil verifikasi'],
        ['key' => 'disetujui', 'label' => 'Disetujui', 'desc' => 'Pengajuan diterima'],
        ['key' => 'diserahkan', 'label' => 'Diserahkan', 'desc' => 'Serah terima selesai'],
    ];

    $currentIdx = match(strtolower($status ?? '')) {
        'diajukan' => 1, // saat diajukan, statusnya sedang diperiksa
        'diterima' => 2,
        'selesai' => 3,
        default => 0,
    };
@endphp

<div class="claim-stepper">
    @foreach ($steps as $idx => $step)
        <div class="stepper-step {{ $idx <= $currentIdx ? 'completed' : '' }} {{ $idx === $currentIdx ? 'active' : '' }}">
            <div class="stepper-indicator">
                @if ($idx < $currentIdx)
                    ✓
                @else
                    {{ $idx + 1 }}
                @endif
            </div>
            <div class="stepper-details">
                <span class="stepper-title">{{ $step['label'] }}</span>
                <span class="stepper-sub">{{ $step['desc'] }}</span>
            </div>
        </div>
    @endforeach
</div>

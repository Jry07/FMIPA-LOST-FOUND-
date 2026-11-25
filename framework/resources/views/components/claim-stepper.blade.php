@props([
    'step' => null,
    'status' => null,
    'claim' => null,
])

@php
    if ($claim) {
        $status = $status ?? $claim->status;
        if (is_null($step)) {
            $statusLower = strtolower($claim->status ?? '');
            $hasHandover = (isset($claim->item) && $claim->item->handoverRecord) || $claim->handoverRecord || (isset($claim->item) && $claim->item->status === 'selesai');
            if ($statusLower === 'ditolak') {
                $step = 2;
            } elseif ($hasHandover) {
                $step = 4;
            } elseif ($statusLower === 'diterima') {
                $step = 3;
            } else {
                $step = 2;
            }
        }
    }

    $step = $step ?? 1;
    $status = $status ?? 'diajukan';

    $steps = [
        1 => ['title' => 'Pengajuan Diajukan', 'desc' => 'Klaim/laporan penemuan tersimpan di sistem'],
        2 => ['title' => 'Verifikasi Berkas & Bukti', 'desc' => 'Pemeriksaan bukti kepemilikan oleh petugas'],
        3 => ['title' => 'Verifikasi Fisik & Serah Terima', 'desc' => 'Pencocokan fisik di pos dan penyerahan barang'],
        4 => ['title' => 'Selesai', 'desc' => 'Barang telah berhasil diserahterimakan'],
    ];

    $isRejected = strtolower($status) === 'ditolak';
@endphp

<div class="stepper-wrap">
    <div class="stepper-track">
        @foreach($steps as $idx => $stepInfo)
            @php
                $isPassed = $idx < $step && ! $isRejected;
                $isCurrent = $idx == $step;
                $stateClass = $isRejected && $isCurrent 
                    ? 'step-rejected' 
                    : ($isPassed ? 'step-completed' : ($isCurrent ? 'step-active' : 'step-pending'));
            @endphp
            <div class="stepper-step {{ $stateClass }}">
                <div class="step-marker">
                    @if($isPassed)
                        ✓
                    @elseif($isRejected && $isCurrent)
                        ✕
                    @else
                        {{ $idx }}
                    @endif
                </div>
                <div class="step-content">
                    <span class="step-title">
                        {{ $stepInfo['title'] }}
                        @if($isRejected && $isCurrent)
                            <strong class="text-danger">(Ditolak)</strong>
                        @endif
                    </span>
                    <span class="step-desc">{{ $stepInfo['desc'] }}</span>
                </div>
            </div>
            @if(! $loop->last)
                <div class="stepper-line {{ $idx < $step && ! $isRejected ? 'line-filled' : '' }}"></div>
            @endif
        @endforeach
    </div>
</div>

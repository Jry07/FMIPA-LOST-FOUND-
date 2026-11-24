{{-- >>> [M5-INFO-STEPS] START --}}
{{-- Menerima variabel $item. M5: kotak putih rounded berisi 3 langkah bernomor (Figma hal. 10) --}}

@php
    $isFound = $item->type === (defined('\App\Models\Item::TYPE_FOUND') ? \App\Models\Item::TYPE_FOUND : 'found');
@endphp

<div class="info-steps-card">
    <div class="info-steps-header">
        <h3 class="info-steps-title">
            {{ $isFound ? 'Apa yang terjadi setelah Anda mengajukan klaim?' : 'Apa yang terjadi setelah Anda melaporkan penemuan?' }}
        </h3>
    </div>
    <div class="info-steps-grid">
        @if ($isFound)
            {{-- Langkah untuk Laporan Found (Figma Hal. 10) --}}
            <div class="info-step-item">
                <div class="info-step-number">01</div>
                <div class="info-step-content">
                    <span class="info-step-name">Kirim ciri khusus</span>
                    <p class="info-step-desc">Ceritakan bukti kepemilikan di form privat.</p>
                </div>
            </div>
            <div class="info-step-item">
                <div class="info-step-number">02</div>
                <div class="info-step-content">
                    <span class="info-step-name">Tunggu pemeriksaan</span>
                    <p class="info-step-desc">Mencocokkan bukti dengan barang.</p>
                </div>
            </div>
            <div class="info-step-item">
                <div class="info-step-number">03</div>
                <div class="info-step-content">
                    <span class="info-step-name">Ambil dengan aman</span>
                    <p class="info-step-desc">Setelah disetujui, ikuti arahan serah terima.</p>
                </div>
            </div>
        @else
            {{-- Langkah untuk Laporan Lost (Usulan SRS) --}}
            <div class="info-step-item">
                <div class="info-step-number">01</div>
                <div class="info-step-content">
                    <span class="info-step-name">Kirim info penemuan</span>
                    <p class="info-step-desc">Berikan ciri khusus, waktu, dan lokasi penitipan barang.</p>
                </div>
            </div>
            <div class="info-step-item">
                <div class="info-step-number">02</div>
                <div class="info-step-content">
                    <span class="info-step-name">Tunggu pemeriksaan</span>
                    <p class="info-step-desc">Petugas memvalidasi informasi dengan pelapor kehilangan.</p>
                </div>
            </div>
            <div class="info-step-item">
                <div class="info-step-number">03</div>
                <div class="info-step-content">
                    <span class="info-step-name">Serahkan ke petugas</span>
                    <p class="info-step-desc">Setelah disetujui, lakukan serah terima resmi di kampus.</p>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- <<< [M5-INFO-STEPS] END --}}

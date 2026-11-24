{{-- >>> [M5-ACTION-BUTTON] START --}}
{{-- Menerima variabel $item. M5: tombol Ajukan Klaim / Saya Menemukan Barang Ini --}}

@php
    $isSelesai = $item->status === (defined('\App\Models\Item::STATUS_SELESAI') ? \App\Models\Item::STATUS_SELESAI : 'selesai');
    $isDipublikasikan = $item->status === (defined('\App\Models\Item::STATUS_DIPUBLIKASIKAN') ? \App\Models\Item::STATUS_DIPUBLIKASIKAN : 'dipublikasikan');
    $isFound = $item->type === (defined('\App\Models\Item::TYPE_FOUND') ? \App\Models\Item::TYPE_FOUND : 'found');
    $isLost = $item->type === (defined('\App\Models\Item::TYPE_LOST') ? \App\Models\Item::TYPE_LOST : 'lost');
    $isOwner = auth()->check() && (int) $item->user_id === (int) auth()->id();
@endphp

@if ($isSelesai)
    {{-- Status Selesai: tombol nonaktif 'Sudah diserahterimakan' (NFR-08) --}}
    <button type="button" class="btn-claim-action btn-claim-disabled" disabled>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        Sudah diserahterimakan
    </button>
@elseif ($isDipublikasikan)
    @if ($isFound)
        {{-- Laporan Found + Dipublikasikan: Tombol Ajukan Klaim (Figma Hal. 10) --}}
        @if ($isOwner)
            <div class="badge-owner-info">
                ℹ️ Ini adalah laporan barang ditemukan yang Anda laporkan.
            </div>
        @else
            <a href="{{ route('claims.create', $item) }}" class="btn-claim-action btn-claim-maroon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    <polyline points="9 12 11 14 15 10"></polyline>
                </svg>
                Ajukan Klaim
            </a>
        @endif
    @elseif ($isLost)
        {{-- Laporan Lost + Dipublikasikan: Tombol Saya Menemukan Barang Ini --}}
        @if ($isOwner)
            <div class="badge-owner-info">
                Ini laporan Anda
            </div>
        @else
            <a href="{{ route('claims.finding.create', $item) }}" class="btn-claim-action btn-claim-yellow">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                Saya Menemukan Barang Ini
            </a>
        @endif
    @endif
@endif

{{-- <<< [M5-ACTION-BUTTON] END --}}

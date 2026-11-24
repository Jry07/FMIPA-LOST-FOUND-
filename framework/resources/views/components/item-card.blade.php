@props(['item'])

<div class="item-card">
    <div class="item-card-image-wrap">
        @if($item->photo)
            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="item-card-image">
        @else
            <img src="{{ asset('storage/items/placeholder.svg') }}" alt="Placeholder" class="item-card-image">
        @endif
        <div class="item-card-badges">
            <x-type-badge :type="$item->type" />
            <x-status-badge :status="$item->status" />
        </div>
    </div>
    <div class="item-card-body">
        <span class="item-card-category">{{ $item->category->name ?? 'Kategori' }}</span>
        <h3 class="item-card-title">{{ $item->name }}</h3>
        <p class="item-card-desc">{{ Str::limit($item->description, 90) }}</p>
        <div class="item-card-meta">
            <div class="meta-row">
                <span class="meta-icon">📍</span>
                <span class="meta-text">{{ $item->location }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-icon">📅</span>
                <span class="meta-text">{{ $item->incident_date?->format('d M Y') ?? '-' }}</span>
            </div>
        </div>
    </div>
    <div class="item-card-footer">
        <span class="item-card-code">{{ $item->kode }}</span>
        <a href="{{ route('catalog.show', $item) }}" class="btn-sm btn-yellow">Lihat Detail →</a>
    </div>
</div>

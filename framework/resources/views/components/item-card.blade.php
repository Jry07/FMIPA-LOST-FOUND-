@props(['item'])

<div class="item-card">
    <div class="item-card-image">
        @if ($item->photo)
            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}">
        @else
            <div class="item-card-placeholder">
                <span>📦</span>
            </div>
        @endif
    </div>
    <div class="item-card-body">
        <div class="item-card-meta">
            <x-type-badge :type="$item->type" />
            <x-status-badge :status="$item->status" />
        </div>
        <h4 class="item-card-title">{{ $item->name }}</h4>
        <p class="item-card-location">📍 {{ $item->location }}</p>
        <p class="item-card-date">🗓 {{ $item->incident_date?->format('d M Y') }}</p>
    </div>
</div>

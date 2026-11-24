@props([
    'title' => 'Tidak Ada Data Ditemukan',
    'message' => 'Saat ini belum ada data yang tersedia untuk ditampilkan.',
    'icon' => '📦',
    'actionText' => null,
    'actionUrl' => null,
])

<div class="empty-state-card">
    <div class="empty-state-icon">{{ $icon }}</div>
    <h3 class="empty-state-title">{{ $title }}</h3>
    <p class="empty-state-message">{{ $message }}</p>
    @if($actionText && $actionUrl)
        <div class="empty-state-action">
            <a href="{{ $actionUrl }}" class="btn btn-yellow">{{ $actionText }}</a>
        </div>
    @endif
    {{ $slot }}
</div>

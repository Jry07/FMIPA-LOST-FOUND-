@props(['title' => 'Belum ada data', 'message' => 'Tidak ada data yang ditemukan untuk saat ini.'])

<div class="empty-state">
    <div class="empty-state-icon">📂</div>
    <h3 class="empty-state-title">{{ $title }}</h3>
    <p class="empty-state-text">{{ $message }}</p>
    @if (isset($action))
        <div class="empty-state-action">
            {{ $action }}
        </div>
    @endif
</div>

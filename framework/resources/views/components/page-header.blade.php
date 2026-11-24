@props(['title', 'subtitle' => null])

<div class="page-header">
    <div class="page-header-content">
        <h1 class="page-title">{{ $title }}</h1>
        @if ($subtitle)
            <p class="page-subtitle">{{ $subtitle }}</p>
        @endif
    </div>
    @if (isset($actions))
        <div class="page-header-actions">
            {{ $actions }}
        </div>
    @endif
</div>

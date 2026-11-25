@props(['title', 'description' => null, 'subtitle' => null])

@php
    $sub = $description ?? $subtitle;
@endphp

<div class="page-header-wrap">
    <div class="page-header-left">
        <h1 class="page-title">{{ $title }}</h1>
        @if($sub)
            <p class="page-description">{{ $sub }}</p>
        @endif
    </div>
    @if(isset($actions) || $slot->isNotEmpty())
        <div class="page-header-actions">
            {{ $actions ?? $slot }}
        </div>
    @endif
</div>

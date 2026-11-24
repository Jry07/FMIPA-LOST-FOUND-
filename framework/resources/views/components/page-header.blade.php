@props(['title', 'description' => null])

<div class="page-header-wrap">
    <div class="page-header-left">
        <h1 class="page-title">{{ $title }}</h1>
        @if($description)
            <p class="page-description">{{ $description }}</p>
        @endif
    </div>
    @if(isset($actions) || $slot->isNotEmpty())
        <div class="page-header-actions">
            {{ $actions ?? $slot }}
        </div>
    @endif
</div>

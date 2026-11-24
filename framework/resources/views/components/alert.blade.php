@if (session('success'))
    <div class="alert alert-success">
        <div class="alert-icon">✓</div>
        <div class="alert-content">{{ session('success') }}</div>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        <div class="alert-icon">⚠</div>
        <div class="alert-content">{{ session('error') }}</div>
    </div>
@endif

@if (session('status'))
    <div class="alert alert-info">
        <div class="alert-icon">ℹ</div>
        <div class="alert-content">{{ session('status') }}</div>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <div class="alert-icon">✕</div>
        <div class="alert-content">
            <ul style="margin: 0; padding-left: 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

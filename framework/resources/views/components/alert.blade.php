@if(session('success'))
    <div class="alert alert-success" role="alert">
        <span class="alert-icon">✓</span>
        <div class="alert-body">
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" role="alert">
        <span class="alert-icon">⚠️</span>
        <div class="alert-body">
            <strong>Perhatian:</strong> {{ session('error') }}
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info" role="alert">
        <span class="alert-icon">ℹ️</span>
        <div class="alert-body">
            <strong>Informasi:</strong> {{ session('info') }}
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger" role="alert">
        <span class="alert-icon">⚠️</span>
        <div class="alert-body">
            <strong>Terdapat kesalahan pada input formulir:</strong>
            <ul class="alert-list">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
@endif

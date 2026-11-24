<div class="filter-card">
    <form method="GET" action="{{ route('items.index') }}" class="filter-form" id="katalogFilterForm">
        {{-- Baris 1: Pencarian Utama --}}
        <div class="filter-row filter-search-row">
            <div class="search-input-group">
                <span class="search-icon" aria-hidden="true">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
                <input
                    type="text"
                    name="q"
                    id="filter-q"
                    class="filter-input search-input @error('q') is-invalid @enderror"
                    placeholder="Cari nama barang atau kata kunci deskripsi..."
                    value="{{ request('q') }}"
                    maxlength="100"
                    autocomplete="off"
                >
            </div>
            <button type="submit" class="btn btn-primary btn-search">
                <span>Cari</span>
            </button>
        </div>
        @error('q')
            <div class="form-error-feedback">{{ $message }}</div>
        @enderror

        {{-- Baris 2: Filter Grid --}}
        <div class="filter-grid">
            {{-- Filter Kategori --}}
            <div class="filter-group">
                <label for="filter-category" class="filter-label">Kategori</label>
                <select name="category_id" id="filter-category" class="filter-select @error('category_id') is-invalid @enderror">
                    <option value="">Semua Kategori</option>
                    @if (isset($categories) && count($categories) > 0)
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('category_id')
                    <div class="form-error-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Filter Jenis Laporan --}}
            <div class="filter-group">
                <label for="filter-type" class="filter-label">Jenis Laporan</label>
                <select name="type" id="filter-type" class="filter-select @error('type') is-invalid @enderror">
                    <option value="all" {{ request('type', 'all') === 'all' ? 'selected' : '' }}>Semua Jenis</option>
                    <option value="{{ \App\Models\Item::TYPE_LOST }}" {{ request('type') === \App\Models\Item::TYPE_LOST ? 'selected' : '' }}>
                        Barang Hilang (Lost)
                    </option>
                    <option value="{{ \App\Models\Item::TYPE_FOUND }}" {{ request('type') === \App\Models\Item::TYPE_FOUND ? 'selected' : '' }}>
                        Barang Ditemukan (Found)
                    </option>
                </select>
                @error('type')
                    <div class="form-error-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Filter Lokasi --}}
            <div class="filter-group">
                <label for="filter-location" class="filter-label">Lokasi</label>
                <input
                    type="text"
                    name="location"
                    id="filter-location"
                    class="filter-input @error('location') is-invalid @enderror"
                    placeholder="Contoh: Gedung A, Gazebo..."
                    value="{{ request('location') }}"
                    maxlength="100"
                >
                @error('location')
                    <div class="form-error-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Filter Status --}}
            <div class="filter-group">
                <label for="filter-status" class="filter-label">Status</label>
                <select name="status" id="filter-status" class="filter-select @error('status') is-invalid @enderror">
                    <option value="{{ \App\Models\Item::STATUS_DIPUBLIKASIKAN }}" {{ request('status', \App\Models\Item::STATUS_DIPUBLIKASIKAN) === \App\Models\Item::STATUS_DIPUBLIKASIKAN ? 'selected' : '' }}>
                        Dipublikasikan (Aktif)
                    </option>
                    <option value="{{ \App\Models\Item::STATUS_SELESAI }}" {{ request('status') === \App\Models\Item::STATUS_SELESAI ? 'selected' : '' }}>
                        Selesai (Sudah Diserahkan)
                    </option>
                </select>
                @error('status')
                    <div class="form-error-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Baris 3: Rentang Tanggal Kejadian dan Tombol Aksi --}}
        <div class="filter-bottom-row">
            <div class="filter-dates-group">
                <span class="filter-label filter-label-inline">Tanggal Kejadian:</span>
                <div class="date-inputs">
                    <div class="date-field">
                        <label for="filter-tanggal-dari" class="date-sublabel">Dari</label>
                        <input
                            type="date"
                            name="tanggal_dari"
                            id="filter-tanggal-dari"
                            class="filter-input date-input @error('tanggal_dari') is-invalid @enderror"
                            value="{{ request('tanggal_dari') }}"
                        >
                    </div>
                    <span class="date-separator">—</span>
                    <div class="date-field">
                        <label for="filter-tanggal-sampai" class="date-sublabel">Sampai</label>
                        <input
                            type="date"
                            name="tanggal_sampai"
                            id="filter-tanggal-sampai"
                            class="filter-input date-input @error('tanggal_sampai') is-invalid @enderror"
                            value="{{ request('tanggal_sampai') }}"
                        >
                    </div>
                </div>
                @error('tanggal_dari')
                    <div class="form-error-feedback">{{ $message }}</div>
                @enderror
                @error('tanggal_sampai')
                    <div class="form-error-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="filter-actions">
                @if (request()->hasAny(['q', 'category_id', 'location', 'type', 'status', 'tanggal_dari', 'tanggal_sampai']))
                    <a href="{{ route('items.index') }}" class="btn btn-outline btn-reset">
                        Reset Filter
                    </a>
                @endif
                <button type="submit" class="btn btn-primary btn-apply">
                    Terapkan Filter
                </button>
            </div>
        </div>
    </form>
</div>

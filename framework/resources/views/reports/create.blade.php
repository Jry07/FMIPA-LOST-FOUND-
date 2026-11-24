@extends('layouts.dashboard')

@section('title', 'Laporkan Barang - FMIPA Lost & Found')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/laporan-dashboard.css') }}">
@endpush

@section('content')
<div class="report-create-wrapper">
    {{-- Header --}}
    <div class="dashboard-page-header">
        <div>
            <div class="dashboard-pretitle">FORMULIR PELAPORAN</div>
            <h1 class="dashboard-title">Laporkan Barang</h1>
            <p class="dashboard-subtitle">Bantu civitas akademika FMIPA menemukan barang yang hilang atau melaporkan temuan.</p>
        </div>
    </div>

    @if (session('error'))
        <div style="background-color: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- Layout 2 Kolom: Form di Kiri, Panduan di Kanan (Sesuai Figma) --}}
    <div class="report-form-layout">
        {{-- Kolom Kiri: Form --}}
        <div class="form-card">
            <h2 class="form-card-title">Informasi Barang</h2>
            <p class="form-card-subtitle">Semua isian bertanda <span style="color: #DC2626;">*</span> wajib diisi.</p>

            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" id="form-laporan">
                @csrf

                {{-- 1. Pilihan Jenis Laporan (Radio Card) --}}
                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Jenis laporan <span style="color: #DC2626;">*</span>
                    </label>
                    <div class="report-type-toggle">
                        <label class="report-type-option {{ old('type', 'lost') === 'lost' ? 'active' : '' }}">
                            <input type="radio" name="type" value="lost" {{ old('type', 'lost') === 'lost' ? 'checked' : '' }}>
                            <span>Barang Hilang</span>
                        </label>
                        <label class="report-type-option {{ old('type') === 'found' ? 'active' : '' }}">
                            <input type="radio" name="type" value="found" {{ old('type') === 'found' ? 'checked' : '' }}>
                            <span>Barang Ditemukan</span>
                        </label>
                    </div>
                    @error('type')
                        <span style="color: #DC2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 2. Nama Barang --}}
                <div style="margin-bottom: 18px;">
                    <label for="name" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                        Nama barang <span style="color: #DC2626;">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           placeholder="Gunakan nama yang mudah dicari, tanpa informasi rahasia"
                           style="width: 100%; padding: 10px 14px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; box-sizing: border-box;"
                           required maxlength="100">
                    <small style="display: block; color: #6B7280; font-size: 12px; margin-top: 4px;">Contoh: Tumbler Hijau Sage, Laptop Hitam, Kunci Motor Honda</small>
                    @error('name')
                        <span style="color: #DC2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 3. Kategori Barang --}}
                <div style="margin-bottom: 18px;">
                    <label for="category_id" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                        Kategori barang <span style="color: #DC2626;">*</span>
                    </label>
                    <select id="category_id" name="category_id"
                            style="width: 100%; padding: 10px 14px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; background: #fff; box-sizing: border-box;"
                            required>
                        <option value="">Pilih kategori barang...</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span style="color: #DC2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 4. Deskripsi Barang --}}
                <div style="margin-bottom: 18px;">
                    <label for="description" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                        Deskripsi barang <span style="color: #DC2626;">*</span>
                    </label>
                    <textarea id="description" name="description" rows="4"
                              placeholder="Tuliskan ciri umum saja. Jangan tulis nomor seri atau tanda khusus untuk verifikasi."
                              style="width: 100%; padding: 10px 14px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; box-sizing: border-box; resize: vertical;"
                              required minlength="10">{{ old('description') }}</textarea>
                    <small style="display: block; color: #6B7280; font-size: 12px; margin-top: 4px;">Minimal 10 karakter.</small>
                    @error('description')
                        <span style="color: #DC2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 5. Unggah Foto Barang (Opsional, Dropzone & Preview) --}}
                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                        Foto barang (Opsional)
                    </label>
                    
                    <input type="file" id="photo-input" name="photo" accept="image/jpeg,image/png,image/jpg,image/webp" style="display: none;">

                    <div class="upload-dropzone" id="photo-dropzone">
                        <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        <div class="upload-text-main">Unggah foto barang yang jelas</div>
                        <div class="upload-text-sub">JPG, JPEG, PNG, atau WEBP · Maksimal 2 MB</div>
                        <button type="button" class="btn-m3-outline" style="padding: 6px 14px; font-size: 13px;">
                            Pilih Foto
                        </button>
                    </div>

                    {{-- Bar Preview Foto (Muncul via JavaScript) --}}
                    <div class="upload-preview-bar" id="photo-preview-bar" style="display: none;">
                        <img src="" alt="Preview Foto" class="upload-preview-thumb" id="photo-preview-img">
                        <div class="upload-preview-info">
                            <div class="upload-preview-name" id="photo-preview-name">nama-file.jpg</div>
                            <div class="upload-preview-size" id="photo-preview-size">1.2 MB · Berhasil dipilih</div>
                        </div>
                        <button type="button" class="upload-preview-remove" id="btn-remove-photo" title="Hapus foto">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>

                    @error('photo')
                        <span style="color: #DC2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 6. Lokasi Kejadian (Label Dinamis) --}}
                <div style="margin-bottom: 18px;">
                    <label id="label-lokasi" for="location" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                        Lokasi Kehilangan <span style="color: #DC2626;">*</span>
                    </label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}"
                           placeholder="Contoh: Taman FMIPA / Area Parkir / Gedung Kuliah B"
                           style="width: 100%; padding: 10px 14px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; box-sizing: border-box;"
                           required maxlength="150">
                    @error('location')
                        <span style="color: #DC2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 7. Tanggal dan Jam Kejadian --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 24px;">
                    <div>
                        <label for="incident_date" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                            Tanggal kejadian <span style="color: #DC2626;">*</span>
                        </label>
                        <input type="date" id="incident_date" name="incident_date"
                               value="{{ old('incident_date', date('Y-m-d')) }}"
                               max="{{ date('Y-m-d') }}"
                               style="width: 100%; padding: 10px 14px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; box-sizing: border-box;"
                               required>
                        <small style="display: block; color: #6B7280; font-size: 11px; margin-top: 4px;">Tanggal saat barang ditemukan atau terakhir terlihat.</small>
                        @error('incident_date')
                            <span style="color: #DC2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="incident_time" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                            Jam kejadian (Opsional)
                        </label>
                        <input type="time" id="incident_time" name="incident_time"
                               value="{{ old('incident_time') }}"
                               style="width: 100%; padding: 10px 14px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
                        <small style="display: block; color: #6B7280; font-size: 11px; margin-top: 4px;">Perkiraan jam (contoh: 14:30).</small>
                        @error('incident_time')
                            <span style="color: #DC2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div style="display: flex; gap: 12px; align-items: center; border-top: 1px solid #E5E7EB; padding-top: 20px;">
                    <button type="submit" class="btn-m3-maroon">
                        Simpan Laporan &check;
                    </button>
                    <a href="{{ route('my-reports.index') }}" class="btn-m3-outline">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        {{-- Kolom Kanan: Panduan Laporan (Sesuai Figma) --}}
        <div class="guide-card">
            <div class="guide-label">PANDUAN LAPORAN</div>
            <h3 class="guide-headline">Informasi yang tepat, bantuan lebih cepat.</h3>

            <div class="guide-item">
                <div class="guide-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                </div>
                <div>
                    <div class="guide-item-title">Gunakan foto yang jelas</div>
                    <div class="guide-item-desc">Tampilkan kondisi umum barang tanpa data atau dokumen pribadi terlihat jelas.</div>
                </div>
            </div>

            <div class="guide-item">
                <div class="guide-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <div>
                    <div class="guide-item-title">Tulis lokasi spesifik</div>
                    <div class="guide-item-desc">Contoh: meja baca lantai 2, gazebo samping gedung A, atau dekat pintu masuk perpustakaan.</div>
                </div>
            </div>

            <div class="guide-item">
                <div class="guide-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div>
                    <div class="guide-item-title">Tunggu verifikasi</div>
                    <div class="guide-item-desc">Laporan Anda akan ditinjau admin sebelum dipublikasikan ke katalog umum kampus.</div>
                </div>
            </div>

            <div class="guide-notice-box">
                <strong style="display: block; margin-bottom: 4px;">&check; Simpan ciri khusus untuk verifikasi</strong>
                Jangan publikasikan nomor seri atau isi dompet. Tanda rahasia ini digunakan saat proses verifikasi klaim kepemilikan.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/laporan.js') }}"></script>
@endpush

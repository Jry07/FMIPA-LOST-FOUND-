@extends('layouts.dashboard')

@section('title', 'Ubah Laporan - FMIPA Lost & Found')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/laporan-dashboard.css') }}">
@endpush

@section('content')
<div class="report-edit-wrapper">
    {{-- Header --}}
    <div class="dashboard-page-header">
        <div>
            <div class="dashboard-pretitle">PENGELOLAAN LAPORAN</div>
            <h1 class="dashboard-title">Ubah Laporan Barang</h1>
            <p class="dashboard-subtitle">Perbarui informasi laporan barang hilang atau temuan Anda sebelum diverifikasi admin.</p>
        </div>
    </div>

    @if (session('error'))
        <div style="background-color: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="report-form-layout">
        <div class="form-card">
            <h2 class="form-card-title">Informasi Barang</h2>
            <p class="form-card-subtitle">Semua isian bertanda <span style="color: #DC2626;">*</span> wajib diisi.</p>

            <form action="{{ route('my-reports.update', $item) }}" method="POST" enctype="multipart/form-data" id="form-laporan">
                @csrf
                @method('PUT')

                {{-- 1. Pilihan Jenis Laporan --}}
                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Jenis laporan <span style="color: #DC2626;">*</span>
                    </label>
                    <div class="report-type-toggle">
                        <label class="report-type-option {{ old('type', $item->type) === 'lost' ? 'active' : '' }}">
                            <input type="radio" name="type" value="lost" {{ old('type', $item->type) === 'lost' ? 'checked' : '' }}>
                            <span>Barang Hilang</span>
                        </label>
                        <label class="report-type-option {{ old('type', $item->type) === 'found' ? 'active' : '' }}">
                            <input type="radio" name="type" value="found" {{ old('type', $item->type) === 'found' ? 'checked' : '' }}>
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
                    <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}"
                           placeholder="Gunakan nama yang mudah dicari, tanpa informasi rahasia"
                           style="width: 100%; padding: 10px 14px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; box-sizing: border-box;"
                           required maxlength="100">
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
                            <option value="{{ $cat->id }}" {{ old('category_id', $item->category_id) == $cat->id ? 'selected' : '' }}>
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
                              required minlength="10">{{ old('description', $item->description) }}</textarea>
                    @error('description')
                        <span style="color: #DC2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 5. Unggah / Ganti Foto Barang --}}
                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                        Foto barang (Opsional)
                    </label>

                    @if ($item->photo)
                        <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 12px; padding: 10px; background-color: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 8px;">
                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}"
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #D1D5DB;">
                            <div style="font-size: 12px; color: #4B5563;">
                                <strong>Foto saat ini tersimpan.</strong><br>
                                Unggah foto baru di bawah jika ingin menggantinya.
                            </div>
                        </div>
                    @endif

                    <input type="file" id="photo-input" name="photo" accept="image/jpeg,image/png,image/jpg,image/webp" style="display: none;">

                    <div class="upload-dropzone" id="photo-dropzone">
                        <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        <div class="upload-text-main">Pilih foto baru untuk mengganti foto lama</div>
                        <div class="upload-text-sub">JPG, JPEG, PNG, atau WEBP · Maksimal 2 MB</div>
                        <button type="button" class="btn-m3-outline" style="padding: 6px 14px; font-size: 13px;">
                            Pilih Foto Baru
                        </button>
                    </div>

                    <div class="upload-preview-bar" id="photo-preview-bar" style="display: none;">
                        <img src="" alt="Preview Foto Baru" class="upload-preview-thumb" id="photo-preview-img">
                        <div class="upload-preview-info">
                            <div class="upload-preview-name" id="photo-preview-name">foto-baru.jpg</div>
                            <div class="upload-preview-size" id="photo-preview-size">1.2 MB · Berhasil dipilih</div>
                        </div>
                        <button type="button" class="upload-preview-remove" id="btn-remove-photo" title="Batal ganti foto">
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

                {{-- 6. Lokasi Kejadian --}}
                <div style="margin-bottom: 18px;">
                    <label id="label-lokasi" for="location" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                        {{ $item->type === 'lost' ? 'Lokasi Kehilangan' : 'Lokasi Penemuan' }} <span style="color: #DC2626;">*</span>
                    </label>
                    <input type="text" id="location" name="location" value="{{ old('location', $item->location) }}"
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
                               value="{{ old('incident_date', $item->incident_date) }}"
                               max="{{ date('Y-m-d') }}"
                               style="width: 100%; padding: 10px 14px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; box-sizing: border-box;"
                               required>
                        @error('incident_date')
                            <span style="color: #DC2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="incident_time" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                            Jam kejadian (Opsional)
                        </label>
                        <input type="time" id="incident_time" name="incident_time"
                               value="{{ old('incident_time', $item->incident_time ? substr($item->incident_time, 0, 5) : '') }}"
                               style="width: 100%; padding: 10px 14px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
                        @error('incident_time')
                            <span style="color: #DC2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div style="display: flex; gap: 12px; align-items: center; border-top: 1px solid #E5E7EB; padding-top: 20px;">
                    <button type="submit" class="btn-m3-maroon">
                        Perbarui Laporan &check;
                    </button>
                    <a href="{{ route('my-reports.index') }}" class="btn-m3-outline">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        {{-- Kolom Kanan: Panduan --}}
        <div class="guide-card">
            <div class="guide-label">PENGINGAT PERUBAHAN</div>
            <h3 class="guide-headline">Perubahan Laporan</h3>
            <p style="font-size: 13px; color: #4B5563; line-height: 1.5; margin-bottom: 16px;">
                Anda hanya dapat mengubah isi laporan selama statusnya masih <strong>Menunggu Verifikasi</strong>.
            </p>
            <div class="guide-notice-box">
                Setiap perubahan akan dicatat ke dalam riwayat audit status laporan oleh sistem.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/laporan.js') }}"></script>
@endpush

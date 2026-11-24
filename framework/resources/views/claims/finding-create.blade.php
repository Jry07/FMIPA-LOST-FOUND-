@extends('layouts.app')

@section('title', 'Lapor Penemuan Barang - FMIPA Lost & Found')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/klaim.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/modules/klaim.js') }}"></script>
@endpush

@section('content')
<div class="claim-form-wrapper">
    <div class="claim-card">
        {{-- Header Kartu Form --}}
        <div class="claim-card-header">
            <h1 class="claim-card-title">Saya Menemukan Barang Ini</h1>
            <p class="claim-card-subtitle">
                Laporkan rincian barang hilang yang Anda temukan agar dapat dicocokkan dan dikembalikan kepada pemilik sah.
            </p>
        </div>

        {{-- Ringkasan Laporan Barang Hilang (Sisi Atas Form) --}}
        <div class="item-summary-strip">
            @php
                $photoUrl = !empty($item->photo) ? asset('storage/' . $item->photo) : asset('images/placeholder-item.png');
                $itemKode = $item->kode ?? ('LST-' . str_pad($item->id, 3, '0', STR_PAD_LEFT));
            @endphp
            <img src="{{ $photoUrl }}" alt="{{ $item->name }}" class="item-summary-thumb" onerror="this.src='https://placehold.co/100x100?text=Barang';">
            <div class="item-summary-info">
                <div class="item-summary-badge-group">
                    <span class="item-summary-code">{{ $itemKode }}</span>
                    <span class="badge-type-tag">Barang Hilang Dicari</span>
                </div>
                <h2 class="item-summary-name">{{ $item->name }}</h2>
                <div class="item-summary-meta">
                    <span>📍 Hilang di: {{ $item->location }}</span> &bull; 
                    <span>📅 Kejadian: {{ $item->incident_date ? \Carbon\Carbon::parse($item->incident_date)->translatedFormat('d M Y') : '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Form Pelaporan Penemuan (FR-09) --}}
        <form action="{{ route('claims.finding.store', $item) }}" method="POST" enctype="multipart/form-data" class="claim-card-body">
            @csrf

            @if ($errors->any())
                <div style="background-color: #fee2e2; border: 1px solid #fecaca; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px;">
                    <strong style="color: #991b1b; font-size: 0.9rem;">Terdapat kesalahan pada isian Anda:</strong>
                    <ul style="color: #b91c1c; font-size: 0.85rem; margin: 6px 0 0 18px; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 1. Deskripsi Penemuan & Kondisi Barang --}}
            <div class="form-group-klaim">
                <label for="finding_description" class="form-label-klaim">
                    Deskripsi Penemuan &amp; Kondisi Barang <span class="required">*</span>
                </label>
                <div class="form-hint-klaim">
                    Ceritakan ciri, kondisi saat ditemukan, serta hal penting lain terkait barang tersebut (minimal 20 karakter).
                </div>
                <textarea 
                    name="finding_description" 
                    id="finding_description" 
                    rows="4" 
                    class="form-control-klaim @error('finding_description') is-invalid @enderror"
                    placeholder="Contoh: Barang ditemukan tergeletak di kursi gazebo lantai 2, kondisi masih menyala dan terdapat casing pelindung..."
                    required
                >{{ old('finding_description') }}</textarea>
                @error('finding_description')
                    <span class="invalid-feedback-klaim">{{ $message }}</span>
                @enderror
            </div>

            {{-- 2. Lokasi Ditemukan --}}
            <div class="form-group-klaim">
                <label for="finding_location" class="form-label-klaim">
                    Lokasi Ditemukan <span class="required">*</span>
                </label>
                <div class="form-hint-klaim">
                    Tuliskan tempat spesifik di lingkungan FMIPA tempat barang ditemukan.
                </div>
                <input 
                    type="text" 
                    name="finding_location" 
                    id="finding_location" 
                    class="form-control-klaim @error('finding_location') is-invalid @enderror"
                    value="{{ old('finding_location') }}"
                    placeholder="Misalnya: Laboratorium Komputer Dasar 1 atau Gazebo Belakang Gedung A"
                    required
                >
                @error('finding_location')
                    <span class="invalid-feedback-klaim">{{ $message }}</span>
                @enderror
            </div>

            {{-- 3. Waktu Ditemukan --}}
            <div class="form-group-klaim">
                <label for="finding_time" class="form-label-klaim">
                    Waktu Ditemukan <span class="required">*</span>
                </label>
                <div class="form-hint-klaim">
                    Pilih tanggal dan waktu saat barang ditemukan (tidak boleh di masa depan).
                </div>
                <input 
                    type="datetime-local" 
                    name="finding_time" 
                    id="finding_time" 
                    class="form-control-klaim @error('finding_time') is-invalid @enderror"
                    value="{{ old('finding_time', now()->format('Y-m-d\TH:i')) }}"
                    max="{{ now()->format('Y-m-d\TH:i') }}"
                    required
                >
                @error('finding_time')
                    <span class="invalid-feedback-klaim">{{ $message }}</span>
                @enderror
            </div>

            {{-- 4. Lokasi Penyimpanan / Penitipan --}}
            <div class="form-group-klaim">
                <label for="storage_location" class="form-label-klaim">
                    Lokasi Penyimpanan / Penitipan Saat Ini <span class="required">*</span>
                </label>
                <div class="form-hint-klaim">
                    Informasikan di mana barang saat ini disimpan atau dititipkan (misalnya: Pos Satpam Kampus Baru, Ruang Staf Dekanat, atau masih dipegang penemu).
                </div>
                <input 
                    type="text" 
                    name="storage_location" 
                    id="storage_location" 
                    class="form-control-klaim @error('storage_location') is-invalid @enderror"
                    value="{{ old('storage_location') }}"
                    placeholder="Contoh: Dititipkan di Pos Satpam Pintu Masuk FMIPA"
                    required
                >
                @error('storage_location')
                    <span class="invalid-feedback-klaim">{{ $message }}</span>
                @enderror
            </div>

            {{-- 5. Foto / Bukti Penemuan --}}
            <div class="form-group-klaim">
                <label for="evidence" class="form-label-klaim">
                    Foto / Bukti Penemuan Barang <span class="required">*</span>
                </label>
                <div class="form-hint-klaim">
                    Unggah foto jelas barang yang Anda temukan saat ini sebagai bukti fisik. Format JPG, PNG, atau WEBP (maks. 2 MB).
                </div>

                <div class="upload-dropzone" id="uploadDropzone" onclick="document.getElementById('evidence').click();">
                    <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                    <div class="upload-text">Klik untuk memilih berkas atau seret ke sini</div>
                    <div class="upload-subtext">JPG, JPEG, PNG, atau WEBP hingga 2 MB</div>
                </div>

                <input 
                    type="file" 
                    name="evidence" 
                    id="evidence" 
                    accept="image/jpeg,image/png,image/jpg,image/webp" 
                    style="display: none;" 
                    required
                >

                <div id="fileErrorMsg" class="invalid-feedback-klaim" style="display: none;"></div>

                <div class="preview-container" id="previewContainer">
                    <img src="" alt="Pratinjau Foto Penemuan" id="previewImage" class="preview-image">
                    <button type="button" class="preview-remove-btn" id="removePreviewBtn" title="Hapus foto">&times;</button>
                </div>

                @error('evidence')
                    <span class="invalid-feedback-klaim">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tombol Aksi Form --}}
            <div class="claim-form-actions">
                <a href="{{ route('items.show', $item) }}" class="btn-secondary-klaim">
                    Batal
                </a>
                <button type="submit" class="btn-submit-klaim">
                    Kirim Laporan Penemuan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

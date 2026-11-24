@extends('layouts.app')

@section('title', 'Form Pengajuan Klaim - FMIPA Lost & Found')

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
            <h1 class="claim-card-title">Ajukan Klaim Kepemilikan</h1>
            <p class="claim-card-subtitle">
                Isi bukti dan ciri khusus barang untuk diverifikasi oleh admin dan petugas FMIPA.
            </p>
        </div>

        {{-- Ringkasan Barang yang Diklaim (Sisi Atas Form) --}}
        <div class="item-summary-strip">
            @php
                $photoUrl = !empty($item->photo) ? asset('storage/' . $item->photo) : asset('images/placeholder-item.png');
                $itemKode = $item->kode ?? ('FND-' . str_pad($item->id, 3, '0', STR_PAD_LEFT));
            @endphp
            <img src="{{ $photoUrl }}" alt="{{ $item->name }}" class="item-summary-thumb" onerror="this.src='https://placehold.co/100x100?text=Barang';">
            <div class="item-summary-info">
                <div class="item-summary-badge-group">
                    <span class="item-summary-code">{{ $itemKode }}</span>
                    <span class="badge-type-tag">Barang Ditemukan</span>
                </div>
                <h2 class="item-summary-name">{{ $item->name }}</h2>
                <div class="item-summary-meta">
                    <span>📍 {{ $item->location }}</span> &bull; 
                    <span>📅 {{ $item->incident_date ? \Carbon\Carbon::parse($item->incident_date)->translatedFormat('d M Y') : '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Form Pengajuan Klaim --}}
        <form action="{{ route('claims.store', $item) }}" method="POST" enctype="multipart/form-data" class="claim-card-body">
            @csrf

            {{-- Alert Error Global --}}
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

            {{-- 1. Deskripsi Kepemilikan (Ciri Khusus) --}}
            <div class="form-group-klaim">
                <label for="ownership_description" class="form-label-klaim">
                    Deskripsi Kepemilikan &amp; Ciri Khusus <span class="required">*</span>
                </label>
                <div class="form-hint-klaim">
                    Jelaskan detail spesifik yang hanya diketahui oleh pemilik asli (contoh: stiker khusus, goresan tersembunyi, nomor seri, isi dompet/tas, dsb.). Minimal 20 karakter.
                </div>
                <textarea 
                    name="ownership_description" 
                    id="ownership_description" 
                    rows="5" 
                    class="form-control-klaim @error('ownership_description') is-invalid @enderror"
                    placeholder="Tuliskan ciri khusus barang yang membuktikan bahwa barang ini adalah milik Anda..."
                    required
                >{{ old('ownership_description') }}</textarea>
                @error('ownership_description')
                    <span class="invalid-feedback-klaim">{{ $message }}</span>
                @enderror
            </div>

            {{-- 2. Unggah Bukti Kepemilikan (NFR-05: Bukti Privat) --}}
            <div class="form-group-klaim">
                <label for="evidence" class="form-label-klaim">
                    Bukti Kepemilikan (Foto / Dokumen Pendukung) <span class="required">*</span>
                </label>
                <div class="form-hint-klaim">
                    Unggah bukti kepemilikan seperti nota pembelian, foto Anda bersama barang sebelum hilang, atau bukti sah lainnya. Maksimal 2 MB (JPG, JPEG, PNG, WEBP). Bukti disimpan secara privat dan hanya dapat dilihat oleh petugas verifikator.
                </div>

                {{-- Area Dropzone / Upload --}}
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

                {{-- Pesan error JS jika ada --}}
                <div id="fileErrorMsg" class="invalid-feedback-klaim" style="display: none;"></div>

                {{-- Pratinjau Gambar Live --}}
                <div class="preview-container" id="previewContainer">
                    <img src="" alt="Pratinjau Bukti" id="previewImage" class="preview-image">
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
                    Kirim Pengajuan Klaim
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

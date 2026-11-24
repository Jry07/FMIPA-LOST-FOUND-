@extends('layouts.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/verifikasi.css') }}">
@endpush

@section('dashboard')
    <x-page-header 
        title="Formulir Serah Terima Barang: {{ $claim->item->kode }}" 
        subtitle="Petugas mencocokkan identitas fisik penerima dan mencatat berita acara serah terima barang."
    >
        <x-slot:actions>
            <a href="{{ route('handovers.index') }}" class="btn btn-sm btn-outline-secondary">
                ← Kembali ke Daftar
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="detail-grid">
        {{-- Kolom Kiri: Ringkasan Barang & Pengajuan --}}
        <div class="detail-media-card">
            <div class="detail-image-wrapper">
                @if ($claim->item->photo)
                    <img src="{{ asset('storage/' . $claim->item->photo) }}" alt="{{ $claim->item->name }}">
                @else
                    <div class="detail-image-placeholder">📦</div>
                @endif
            </div>

            <div class="detail-summary-body">
                <div class="detail-code">Laporan: {{ $claim->item->kode }}</div>
                <h2 class="detail-item-title">{{ $claim->item->name }}</h2>

                <div style="margin-bottom: 1rem; display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                    <x-type-badge :type="$claim->item->type" />
                    <x-status-badge :status="$claim->item->status" />
                </div>

                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">Kategori</span>
                        <span class="info-value">{{ $claim->item->category?->name ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Lokasi Ditemukan/Hilang</span>
                        <span class="info-value">📍 {{ $claim->item->location }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kode Pengajuan</span>
                        <span class="info-value">{{ $claim->kode }} (<x-status-badge :status="$claim->status" />)</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Diverifikasi Pada</span>
                        <span class="info-value">{{ $claim->verified_at ? $claim->verified_at->format('d M Y, H:i') : '-' }}</span>
                    </div>
                </div>

                @if ($claim->evidence)
                    <div style="margin-top: 1.25rem;">
                        <a href="{{ route('claims.evidence', $claim) }}" target="_blank" class="btn btn-sm btn-yellow" style="width: 100%;">
                            👁️ Periksa Bukti Pengajuan ({{ basename($claim->evidence) }})
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Kolom Kanan: Identifikasi Penerima & Form Pencatatan --}}
        <div class="detail-content-card">
            {{-- Kotak Penerima yang Sah --}}
            <div class="receiver-highlight-box">
                <div class="receiver-highlight-title">
                    🎯 PENERIMA YANG SAH:
                    @if ($claim->item->type === \App\Models\Item::TYPE_FOUND)
                        Pengaju Klaim Kepemilikan
                    @else
                        Pembuat Laporan Kehilangan (Lost)
                    @endif
                </div>
                <div class="user-identity-box" style="background-color: #FFFFFF;">
                    <div class="user-avatar-circle" style="background-color: var(--yellow); color: var(--text-dark);">
                        {{ strtoupper(substr($receiver->name, 0, 1)) }}
                    </div>
                    <div class="user-identity-info">
                        <h4>{{ $receiver->name }}</h4>
                        <p>NIM: <strong>{{ $receiver->nim ?? '-' }}</strong> &bull; Email: {{ $receiver->email }}</p>
                        <p style="margin-top: 0.25rem; font-size: 0.8rem; color: var(--text-muted);">
                            Peran dalam Kasus: 
                            <strong>
                                {{ $claim->item->type === \App\Models\Item::TYPE_FOUND ? 'Pengaju Klaim (Pemilik Barang)' : 'Pembuat Laporan Kehilangan' }}
                            </strong>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Pencatatan Serah Terima --}}
            <form action="{{ route('handovers.store', $claim) }}" method="POST" id="handoverForm">
                @csrf

                <div class="section-box">
                    <h3 class="section-title">🔍 Pemeriksaan Fisik &amp; Identitas</h3>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">
                        Petugas wajib memeriksa secara langsung Kartu Tanda Mahasiswa (KTM) atau kartu identitas resmi lainnya dari penerima di atas, serta mencocokkan barang fisik dengan bukti yang diajukan.
                    </p>

                    <div class="checkbox-card">
                        <input 
                            type="checkbox" 
                            name="identity_confirmed" 
                            id="identity_confirmed" 
                            value="1" 
                            {{ old('identity_confirmed') ? 'checked' : '' }}
                            required
                        >
                        <label for="identity_confirmed">
                            Saya telah memeriksa kartu identitas (KTM/KTP) dan bukti fisik penerima secara langsung, dan menyatakan bahwa identitas serta bukti SESUAI dengan pemilik sah barang.
                        </label>
                    </div>
                    @error('identity_confirmed')
                        <div class="invalid-feedback" style="display: block; margin-top: -0.5rem; margin-bottom: 1rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="section-box">
                    <h3 class="section-title">📝 Catatan Pengembalian</h3>
                    <x-form.textarea 
                        name="return_note" 
                        label="Catatan Serah Terima / Kondisi Barang" 
                        placeholder="Contoh: Barang diserahkan langsung kepada saudara Budi Santoso (NIM F1G125099) di Pos Satpam FMIPA dalam kondisi baik dan lengkap."
                        :required="true"
                        :rows="4"
                    />
                    <small style="color: var(--text-muted); display: block; margin-top: -0.75rem; margin-bottom: 1.25rem;">
                        Maksimal 500 karakter. Catatan ini akan disimpan secara permanen pada riwayat serah terima.
                    </small>
                </div>

                {{-- Tombol Aksi --}}
                <div class="action-buttons-row" style="margin-top: 1rem;">
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan proses serah terima ini? Status laporan akan ditandai Selesai.');">
                        🤝 Simpan Serah Terima
                    </button>

                    {{-- Tombol Tidak Sesuai (SRS FR-11 Langkah 3: Tidak ada data yang disimpan) --}}
                    <a 
                        href="{{ route('handovers.index') }}" 
                        class="btn btn-outline-danger" 
                        onclick="return confirm('Apakah Anda yakin identitas atau bukti fisik TIDAK SESUAI? Proses serah terima tidak akan dilanjutkan dan tidak ada data yang disimpan.');"
                    >
                        ✕ Tidak Sesuai (Batalkan)
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

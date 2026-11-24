@extends('layouts.dashboard')
@section('title', 'Dashboard Petugas - FMIPA Lost & Found')
@section('page_title', 'Dashboard Petugas')
@section('content')
{{-- [M6-VERIFIKASI] --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:28px;">
    <div style="background:#fff;padding:20px;border-radius:12px;border:1px solid var(--border);">
        <span style="font-size:0.8rem;color:var(--gray);font-weight:600;">KLAIM PERLU VERIFIKASI</span>
        <h3 style="font-size:2rem;color:var(--warning);margin-top:6px;">{{ \App\Models\Claim::where('status','diajukan')->count() }}</h3>
        <a href="{{ route('verification.claims.index') }}" style="font-size:0.85rem;color:var(--maroon);font-weight:600;">Proses Sekarang →</a>
    </div>
    <div style="background:#fff;padding:20px;border-radius:12px;border:1px solid var(--border);">
        <span style="font-size:0.8rem;color:var(--gray);font-weight:600;">BARANG MENUNGGU SERAH TERIMA</span>
        <h3 style="font-size:2rem;color:var(--maroon);margin-top:6px;">{{ \App\Models\Claim::where('status','diterima')->count() }}</h3>
        <a href="{{ route('verification.handover.index') }}" style="font-size:0.85rem;color:var(--maroon);font-weight:600;">Catat Serah Terima →</a>
    </div>
    <div style="background:#fff;padding:20px;border-radius:12px;border:1px solid var(--border);">
        <span style="font-size:0.8rem;color:var(--gray);font-weight:600;">TOTAL SERAH TERIMA SELESAI</span>
        <h3 style="font-size:2rem;color:var(--success);margin-top:6px;">{{ \App\Models\HandoverRecord::count() }}</h3>
    </div>
</div>

<div style="background:#fff;padding:24px;border-radius:12px;border:1px solid var(--border);">
    <h3 style="margin-bottom:12px;">Panduan Petugas</h3>
    <ol style="margin-left:20px;line-height:2;color:var(--gray);font-size:0.9rem;">
        <li>Periksa klaim &amp; penemuan yang masuk pada menu <strong>Verifikasi Klaim</strong>.</li>
        <li>Validasi kelengkapan bukti dokumen. Setujui atau tolak klaim.</li>
        <li>Hubungi pemilik sah untuk datang ke Pos Satpam FMIPA membawa identitas (KTM/KTP).</li>
        <li>Cocokkan identitas &amp; barang fisik, lalu catat serah terima pada menu <strong>Catatan Serah Terima</strong>.</li>
    </ol>
</div>
{{-- [/M6-VERIFIKASI] --}}
@endsection

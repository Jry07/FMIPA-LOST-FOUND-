@extends('layouts.dashboard')
@section('title', 'Statistik - Admin')
@section('page_title', 'Statistik Laporan')
@section('content')
{{-- [M1-ADMIN] --}}
<x-page-header title="Statistik Sistem" description="Rekapitulasi data laporan dan klaim FMIPA Lost & Found" />
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:28px;">
    @foreach([
        ['label'=>'Total Laporan','val'=>\App\Models\Item::count(),'color'=>'var(--maroon)'],
        ['label'=>'Barang Hilang','val'=>\App\Models\Item::where('type','lost')->count(),'color'=>'var(--danger)'],
        ['label'=>'Barang Ditemukan','val'=>\App\Models\Item::where('type','found')->count(),'color'=>'var(--success)'],
        ['label'=>'Laporan Selesai','val'=>\App\Models\Item::where('status','selesai')->count(),'color'=>'var(--info)'],
        ['label'=>'Total Klaim','val'=>\App\Models\Claim::count(),'color'=>'var(--warning)'],
        ['label'=>'Pengguna Terdaftar','val'=>\App\Models\User::where('role','pengguna')->count(),'color'=>'var(--gray)'],
    ] as $stat)
    <div style="background:#fff;padding:20px;border-radius:12px;border:1px solid var(--border);">
        <span style="font-size:0.8rem;color:var(--gray);font-weight:600;">{{ strtoupper($stat['label']) }}</span>
        <h3 style="font-size:2rem;color:{{ $stat['color'] }};margin-top:6px;">{{ $stat['val'] }}</h3>
    </div>
    @endforeach
</div>
<div style="background:#fff;padding:24px;border-radius:12px;border:1px solid var(--border);">
    <h3 style="margin-bottom:16px;">Distribusi per Kategori</h3>
    <div class="table-responsive">
        <table class="table-custom">
            <thead><tr><th>Kategori</th><th>Jumlah Lost</th><th>Jumlah Found</th><th>Total</th></tr></thead>
            <tbody>
                @foreach(\App\Models\Category::withCount(['items as lost_count'=>fn($q)=>$q->where('type','lost'),'items as found_count'=>fn($q)=>$q->where('type','found'),'items'])->get() as $cat)
                <tr>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->lost_count }}</td>
                    <td>{{ $cat->found_count }}</td>
                    <td><strong>{{ $cat->items_count }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{-- [/M1-ADMIN] --}}
@endsection

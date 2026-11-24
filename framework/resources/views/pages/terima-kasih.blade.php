@extends('layouts.app')

@section('title', 'Terima Kasih - FMIPA Lost & Found')

@section('content')
<div class="thanks-container" style="max-width: 650px; margin: 60px auto; text-align: center; background: #ffffff; padding: 48px 32px; border-radius: 16px; border: 1px solid var(--border); box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
    <div class="thanks-icon" style="font-size: 4rem; margin-bottom: 20px;">
        🎉
    </div>
    
    <h1 class="thanks-title" style="font-size: 2rem; color: var(--maroon); margin-bottom: 12px;">
        Terimakasih atas partisipasinya !
    </h1>
    
    <p class="thanks-subtitle" style="font-size: 1.1rem; color: var(--gray); margin-bottom: 32px;">
        silahkan menunggu untuk info selanjutnya
    </p>

    <div class="thanks-action">
        <a href="{{ route('home') }}" class="btn btn-yellow" style="padding: 12px 32px; font-size: 1rem; border-radius: 8px;">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection

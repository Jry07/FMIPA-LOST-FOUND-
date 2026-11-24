@extends('layouts.dashboard')

@section('title', 'Notifikasi - FMIPA Lost & Found')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modules/laporan-dashboard.css') }}">
@endpush

@section('content')
<div class="notifications-wrapper">
    {{-- Header --}}
    <div class="dashboard-page-header">
        <div>
            <div class="dashboard-pretitle">PEMBERITAHUAN SISTEM</div>
            <h1 class="dashboard-title">Notifikasi</h1>
            <p class="dashboard-subtitle">Pemberitahuan terkini seputar perkembangan laporan dan klaim barang Anda.</p>
        </div>
        @if (auth()->user()->unreadNotifications->isNotEmpty())
            <div>
                <form action="{{ route('notifications.read-all', [], false) }}" method="POST" style="margin: 0;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-m3-outline" style="font-size: 13px;">
                        Tandai semua dibaca &check;
                    </button>
                </form>
            </div>
        @endif
    </div>

    @if (session('success'))
        <div style="background-color: #DCFCE7; border: 1px solid #86EFAC; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Daftar Notifikasi --}}
    <div class="history-section-card" style="padding: 24px;">
        @if ($notifications->isNotEmpty())
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach ($notifications as $notification)
                    <div class="notification-card-item {{ $notification->read_at ? '' : 'unread' }}">
                        <div style="flex: 1;">
                            <div class="notification-title">
                                {{ $notification->data['title'] ?? ($notification->data['judul'] ?? 'Pemberitahuan Sistem') }}
                            </div>
                            <div class="notification-body">
                                {{ $notification->data['message'] ?? ($notification->data['pesan'] ?? '') }}
                            </div>
                            <div class="notification-time">
                                {{ $notification->created_at->translatedFormat('d F Y, H:i') }} ({{ $notification->created_at->diffForHumans() }})
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 10px; flex-shrink: 0;">
                            @if (!empty($notification->data['url']))
                                <a href="{{ $notification->data['url'] }}" class="btn-m3-outline" style="padding: 6px 12px; font-size: 12px;">
                                    Buka Tautan
                                </a>
                            @endif

                            @if (is_null($notification->read_at))
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-m3-outline" style="padding: 6px 12px; font-size: 12px;" title="Tandai sudah dibaca">
                                        &check; Tandai Dibaca
                                    </button>
                                </form>
                            @else
                                <span style="font-size: 11px; color: #9CA3AF; padding: 6px 10px;">
                                    Sudah dibaca
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 24px;">
                {{ $notifications->links() }}
            </div>
        @else
            <x-empty-state message="Belum ada notifikasi untuk Anda saat ini." />
        @endif
    </div>
</div>
@endsection

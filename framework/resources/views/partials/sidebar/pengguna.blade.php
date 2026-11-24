<aside class="dash-sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">FMIPA <span>Lost &amp; Found</span></a>
    </div>

    <div class="sidebar-user-info">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="user-details">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <span class="user-role-badge badge-pengguna">Pengguna ({{ Auth::user()->nim ?? 'Mahasiswa' }})</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        {{-- [M4-KATALOG] --}}
        <div class="nav-section-title">KATALOG &amp; JELAJAH</div>
        <a href="{{ route('pengguna.dashboard') }}" class="sidebar-item {{ request()->routeIs('pengguna.dashboard') || request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="icon">🏠</span> Beranda Pengguna
        </a>
        <a href="{{ route('catalog.index') }}" class="sidebar-item {{ request()->routeIs('catalog.*') || request()->routeIs('items.index') ? 'active' : '' }}">
            <span class="icon">🔍</span> Temukan Barang
        </a>
        <a href="{{ route('cara-kerja') }}" class="sidebar-item {{ request()->routeIs('cara-kerja') ? 'active' : '' }}">
            <span class="icon">📖</span> Cara Kerja Sistem
        </a>
        {{-- [/M4-KATALOG] --}}

        {{-- [M3-LAPORAN] --}}
        <div class="nav-section-title">PELAPORAN BARANG</div>
        <a href="{{ route('items.create') }}" class="sidebar-item {{ request()->routeIs('items.create') || request()->routeIs('reports.create') ? 'active' : '' }}">
            <span class="icon">➕</span> Laporkan Barang (Lost/Found)
        </a>
        <a href="{{ route('items.my-reports') }}" class="sidebar-item {{ request()->routeIs('items.my-reports') || request()->routeIs('my-reports.*') ? 'active' : '' }}">
            <span class="icon">📋</span> Laporan Saya
        </a>
        @if(Route::has('notifications.index'))
        <a href="{{ route('notifications.index') }}" class="sidebar-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
            <span class="icon">🔔</span> Notifikasi
        </a>
        @endif
        {{-- [/M3-LAPORAN] --}}

        {{-- [M5-KLAIM] --}}
        <div class="nav-section-title">KLAIM &amp; PENEMUAN</div>
        <a href="{{ route('my-claims.index') }}" class="sidebar-item {{ request()->routeIs('claims.my-claims') || request()->routeIs('my-claims.*') ? 'active' : '' }}">
            <span class="icon">🤝</span> Klaim Saya
        </a>
        {{-- [/M5-KLAIM] --}}

        {{-- [M2-AUTH] --}}
        <div class="nav-section-title">AKUN SAYA</div>
        <a href="{{ route('profile.edit') }}" class="sidebar-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <span class="icon">👤</span> Pengaturan Profil
        </a>
        <form action="{{ route('logout') }}" method="POST" class="sidebar-logout-form">
            @csrf
            <button type="submit" class="sidebar-item logout-btn">
                <span class="icon">🚪</span> Keluar (Logout)
            </button>
        </form>
        {{-- [/M2-AUTH] --}}
    </nav>
</aside>

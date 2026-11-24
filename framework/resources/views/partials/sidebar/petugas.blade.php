<aside class="dash-sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('petugas.dashboard') }}">FMIPA <span>Petugas Keamanan</span></a>
    </div>

    <div class="sidebar-user-info">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="user-details">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <span class="user-role-badge badge-petugas">Petugas Kampus</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        {{-- [M6-VERIFIKASI] --}}
        <div class="nav-section-title">VERIFIKASI &amp; SERAH TERIMA</div>
        <a href="{{ route('petugas.dashboard') }}" class="sidebar-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
            <span class="icon">🛡️</span> Dashboard Petugas
        </a>
        <a href="{{ route('verification.claims.index') }}" class="sidebar-item {{ request()->routeIs('verification.claims.*') ? 'active' : '' }}">
            <span class="icon">🔍</span> Verifikasi Klaim &amp; Penemuan
        </a>
        <a href="{{ route('verification.handover.index') }}" class="sidebar-item {{ request()->routeIs('verification.handover.*') ? 'active' : '' }}">
            <span class="icon">📝</span> Catatan Serah Terima
        </a>
        {{-- [/M6-VERIFIKASI] --}}

        {{-- [M4-KATALOG] --}}
        <div class="nav-section-title">KATALOG BARANG</div>
        <a href="{{ route('catalog.index') }}" class="sidebar-item {{ request()->routeIs('catalog.*') ? 'active' : '' }}">
            <span class="icon">📦</span> Cek Barang Fisik
        </a>
        {{-- [/M4-KATALOG] --}}

        {{-- [M2-AUTH] --}}
        <div class="nav-section-title">AKUN</div>
        <a href="{{ route('profile.edit') }}" class="sidebar-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <span class="icon">👤</span> Profil Saya
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

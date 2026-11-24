<aside class="dash-sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}">FMIPA <span>Admin Panel</span></a>
    </div>

    <div class="sidebar-user-info">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="user-details">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <span class="user-role-badge badge-admin">Administrator</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        {{-- [M1-ADMIN] --}}
        <div class="nav-section-title">ADMINISTRASI UTAMA</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="icon">📊</span> Dashboard Admin
        </a>
        <a href="{{ route('admin.categories.index') }}" class="sidebar-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <span class="icon">🏷️</span> Kelola Kategori
        </a>
        <a href="{{ route('admin.users.index') }}" class="sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span class="icon">👥</span> Kelola Akun Pengguna
        </a>
        <a href="{{ route('admin.statistics') }}" class="sidebar-item {{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
            <span class="icon">📈</span> Statistik Laporan
        </a>
        <a href="{{ route('admin.logs') }}" class="sidebar-item {{ request()->routeIs('admin.logs') ? 'active' : '' }}">
            <span class="icon">📜</span> Log Riwayat Status
        </a>
        {{-- [/M1-ADMIN] --}}

        {{-- [M6-VERIFIKASI] --}}
        <div class="nav-section-title">MODERASI &amp; VERIFIKASI</div>
        <a href="{{ route('verification.items.index') }}" class="sidebar-item {{ request()->routeIs('verification.items.*') ? 'active' : '' }}">
            <span class="icon">🔎</span> Verifikasi Laporan Masuk
        </a>
        <a href="{{ route('verification.claims.index') }}" class="sidebar-item {{ request()->routeIs('verification.claims.*') ? 'active' : '' }}">
            <span class="icon">⚖️</span> Verifikasi Klaim &amp; Penemuan
        </a>
        {{-- [/M6-VERIFIKASI] --}}

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

<div class="sidebar-heading">Menu Admin</div>
<ul class="sidebar-menu">
    <li class="sidebar-item">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span>📊</span> Dashboard
        </a>
    </li>

{{-- >>> [M6-SIDEBAR-ADMIN] START --}}
    <li class="sidebar-item">
        <a href="{{ route('verifikasi.reports.index') }}" class="sidebar-link {{ request()->routeIs('verifikasi.reports.*') ? 'active' : '' }}">
            <span>📝</span> Verifikasi Laporan
        </a>
    </li>
    <li class="sidebar-item">
        <a href="{{ route('verifikasi.claims.index') }}" class="sidebar-link {{ request()->routeIs('verifikasi.claims.*') ? 'active' : '' }}">
            <span>🔍</span> Verifikasi Pengajuan
        </a>
    </li>
{{-- <<< [M6-SIDEBAR-ADMIN] END --}}

    <li class="sidebar-item">
        <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <span>🏷️</span> Kelola Kategori
        </a>
    </li>
    <li class="sidebar-item">
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span>👥</span> Kelola Pengguna
        </a>
    </li>
</ul>

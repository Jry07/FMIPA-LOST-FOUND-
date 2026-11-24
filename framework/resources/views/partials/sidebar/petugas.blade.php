<div class="sidebar-heading">Menu Petugas</div>
<ul class="sidebar-menu">
    <li class="sidebar-item">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span>📊</span> Dashboard
        </a>
    </li>

{{-- >>> [M6-SIDEBAR-PETUGAS] START --}}
    <li class="sidebar-item">
        <a href="{{ route('verifikasi.claims.index') }}" class="sidebar-link {{ request()->routeIs('verifikasi.claims.*') ? 'active' : '' }}">
            <span>🔍</span> Verifikasi Pengajuan
        </a>
    </li>
    <li class="sidebar-item">
        <a href="{{ route('handovers.index') }}" class="sidebar-link {{ request()->routeIs('handovers.*') ? 'active' : '' }}">
            <span>🤝</span> Serah Terima
        </a>
    </li>
{{-- <<< [M6-SIDEBAR-PETUGAS] END --}}
</ul>

<div class="sidebar-heading">Menu Pengguna</div>
<ul class="sidebar-menu">
    <li class="sidebar-item">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span>📊</span> Dashboard
        </a>
    </li>
    <li class="sidebar-item">
        <a href="{{ route('my.reports') }}" class="sidebar-link {{ request()->routeIs('my.reports*') ? 'active' : '' }}">
            <span>📋</span> Laporan Saya
        </a>
    </li>
    <li class="sidebar-item">
        <a href="{{ route('my.claims') }}" class="sidebar-link {{ request()->routeIs('my.claims*') ? 'active' : '' }}">
            <span>🔍</span> Klaim Saya
        </a>
    </li>
    <li class="sidebar-item">
        <a href="{{ route('profile') }}" class="sidebar-link {{ request()->routeIs('profile*') ? 'active' : '' }}">
            <span>👤</span> Profil Saya
        </a>
    </li>
</ul>

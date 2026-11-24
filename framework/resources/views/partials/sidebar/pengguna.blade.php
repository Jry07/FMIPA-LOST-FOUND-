<nav class="sidebar-menu">

    {{-- >>> [M3-SIDEBAR-DASHBOARD] START (Rahmah) --}}
    <a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>
        <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        <span>Dashboard</span>
    </a>
    {{-- <<< [M3-SIDEBAR-DASHBOARD] END --}}

    {{-- >>> [M3-SIDEBAR-LAPORAN] START (Rahmah) --}}
    <a href="{{ route('reports.create') }}" @class(['active' => request()->routeIs('reports.create')])>
        <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
        <span>Laporkan Barang</span>
    </a>
    <a href="{{ route('my-reports.index') }}" @class(['active' => request()->routeIs('my-reports.*')])>
        <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        <span>Laporan Saya</span>
    </a>
    {{-- <<< [M3-SIDEBAR-LAPORAN] END --}}

    {{-- >>> [M5-SIDEBAR-KLAIM] START (Elsya) --}}
    <a href="{{ route('my-claims.index') }}" @class(['active' => request()->routeIs('my-claims.*')])>
        <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect><path d="M9 14l2 2 4-4"></path></svg>
        <span>Klaim Saya</span>
    </a>
    {{-- <<< [M5-SIDEBAR-KLAIM] END --}}

    {{-- >>> [M2-SIDEBAR-LOGOUT] START (Ferdy) --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-logout-btn">
            <svg class="sidebar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            <span>Logout</span>
        </button>
    </form>
    {{-- <<< [M2-SIDEBAR-LOGOUT] END --}}

</nav>

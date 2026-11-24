<aside class="sidebar-pengguna">
    <div class="sidebar-brand">
        <span class="sidebar-brand-text">MENU PENGGUNA</span>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ Route::has('dashboard') ? route('dashboard') : url('/dashboard') }}" class="sidebar-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- >>> [M2-SIDEBAR-PROFIL] START --}}
        <li class="sidebar-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <a href="{{ route('profile.edit') }}" class="sidebar-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span>Profil Saya</span>
            </a>
        </li>
        {{-- <<< [M2-SIDEBAR-PROFIL] END --}}

        <li class="sidebar-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <a href="{{ Route::has('reports.my') ? route('reports.my') : url('/laporan-saya') }}" class="sidebar-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span>Laporan Saya</span>
            </a>
        </li>

        <li class="sidebar-item {{ request()->routeIs('claims.*') ? 'active' : '' }}">
            <a href="{{ Route::has('claims.my') ? route('claims.my') : url('/klaim-saya') }}" class="sidebar-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
                <span>Klaim Saya</span>
            </a>
        </li>

        {{-- >>> [M2-SIDEBAR-LOGOUT] START --}}
        <li class="sidebar-item sidebar-logout">
            <form action="{{ route('logout') }}" method="POST" id="form-logout-sidebar">
                @csrf
                <button type="submit" class="sidebar-link sidebar-btn-logout">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </li>
        {{-- <<< [M2-SIDEBAR-LOGOUT] END --}}
    </ul>
</aside>

<aside class="sidebar-pengguna" style="width: 240px; background-color: var(--maroon, #6B1D2F); color: #FFFFFF; min-height: 100vh; padding: 24px 16px; display: flex; flex-direction: column; flex-shrink: 0;">
    {{-- Header Sidebar --}}
    <div style="padding: 0 12px 24px 12px; border-bottom: 1px solid rgba(255, 255, 255, 0.15);">
        <div style="font-size: 11px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #FCD34D;">
            MENU PENGGUNA
        </div>
    </div>

    {{-- Navigasi Sidebar --}}
    <nav style="display: flex; flex-direction: column; gap: 6px; margin-top: 16px; flex: 1;">
        {{-- >>> [M3-SIDEBAR-DASHBOARD] START --}}
        <a href="{{ route('dashboard') }}"
           class="sidebar-menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           style="display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; transition: all 0.2s ease; {{ request()->routeIs('dashboard') ? 'background-color: #FFFFFF; color: var(--maroon, #6B1D2F);' : 'color: #FFFFFF; opacity: 0.85;' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span>Dashboard</span>
        </a>
        {{-- <<< [M3-SIDEBAR-DASHBOARD] END --}}

        <a href="{{ Route::has('profile') ? route('profile') : '#' }}"
           class="sidebar-menu-link {{ request()->routeIs('profile*') ? 'active' : '' }}"
           style="display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; color: #FFFFFF; opacity: 0.85; transition: all 0.2s ease;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Profil Saya</span>
        </a>

        {{-- >>> [M3-SIDEBAR-LAPORAN] START --}}
        <a href="{{ route('my-reports.index') }}"
           class="sidebar-menu-link {{ request()->routeIs('my-reports.*') || request()->routeIs('reports.*') ? 'active' : '' }}"
           style="display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; transition: all 0.2s ease; {{ request()->routeIs('my-reports.*') || request()->routeIs('reports.*') ? 'background-color: #FFFFFF; color: var(--maroon, #6B1D2F);' : 'color: #FFFFFF; opacity: 0.85;' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 11l3 3L22 4"></path>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
            </svg>
            <span>Laporan Saya</span>
        </a>
        {{-- <<< [M3-SIDEBAR-LAPORAN] END --}}

        <a href="{{ Route::has('my-claims.index') ? route('my-claims.index') : '#' }}"
           class="sidebar-menu-link {{ request()->routeIs('my-claims.*') ? 'active' : '' }}"
           style="display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; color: #FFFFFF; opacity: 0.85; transition: all 0.2s ease;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                <polyline points="9 12 11 14 15 10"></polyline>
            </svg>
            <span>Klaim Saya</span>
        </a>

        <div style="margin-top: auto; padding-top: 16px; border-top: 1px solid rgba(255, 255, 255, 0.15);">
            <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" style="margin: 0;">
                @csrf
                <button type="submit"
                        style="width: 100%; display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 8px; background: transparent; border: none; color: #FFFFFF; opacity: 0.85; text-align: left; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </nav>
</aside>

<nav class="site-navbar">
    <div class="nav-container">
        <a href="{{ route('home') }}" class="nav-brand">
            <span class="brand-badge">FMIPA</span>
            <span class="brand-text">Lost &amp; Found</span>
        </a>

        <div class="nav-links">
            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('cara-kerja') }}" class="nav-item {{ request()->routeIs('cara-kerja') ? 'active' : '' }}">Cara Kerja</a>

            @guest
                {{-- Navigasi Tamu --}}
                <a href="{{ route('login') }}" class="btn-nav btn-outline-nav">Masuk</a>
                <a href="{{ route('register') }}" class="btn-nav btn-yellow">Daftar</a>
            @else
                {{-- Navigasi Pengguna Login --}}
                <a href="{{ route('catalog.index') }}" class="nav-item {{ request()->routeIs('catalog.*') ? 'active' : '' }}">Temukan Barang</a>
                @if(Auth::user()->isPengguna())
                    <a href="{{ route('items.create') }}" class="nav-item {{ request()->routeIs('items.create') ? 'active' : '' }}">Laporkan Barang</a>
                @endif
                <div class="user-menu-dropdown">
                    <a href="{{ route(Auth::user()->homeRoute()) }}" class="btn-nav btn-cream">
                        <span>{{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline-form">
                        @csrf
                        <button type="submit" class="btn-nav btn-maroon" title="Keluar">Logout</button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</nav>

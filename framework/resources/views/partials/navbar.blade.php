<nav class="main-navbar">
    <a href="{{ route('home') }}" class="brand-container">
        <span class="brand-logo-text">fmipa <span>Lost &amp; Found</span></span>
    </a>

    <ul class="nav-links">
        <li><a href="{{ route('home') }}" class="nav-link">Beranda</a></li>
        <li><a href="{{ route('how-it-works') }}" class="nav-link">Cara Kerja</a></li>
        <li><a href="{{ route('items.index') }}" class="nav-link">Temukan Barang</a></li>
        <li><a href="{{ route('items.create') }}" class="nav-link">Laporkan Barang</a></li>
    </ul>

    <div class="nav-actions">
        @auth
            <a href="{{ route(auth()->user()->homeRoute()) }}" class="btn btn-sm btn-yellow">
                👤 {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-yellow">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Daftar</a>
        @endauth
    </div>
</nav>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - FMIPA Lost & Found')</title>

    <!-- Google Fonts: Playfair Display & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body class="dashboard-body">
    <div class="dash-wrap">
        {{-- Sidebar dinamis sesuai peran pengguna saat ini --}}
        @if(Auth::check() && Auth::user()->isAdmin())
            @include('partials.sidebar.admin')
        @elseif(Auth::check() && Auth::user()->isPetugas())
            @include('partials.sidebar.petugas')
        @else
            @include('partials.sidebar.pengguna')
        @endif

        <div class="dash-main">
            <header class="dash-topbar">
                <div class="topbar-left">
                    <h2 class="dash-heading">@yield('page_title', 'Dashboard')</h2>
                </div>
                <div class="topbar-right">
                    <span class="user-greeting">Halo, <strong>{{ Auth::user()->name ?? 'Pengguna' }}</strong></span>
                    <a href="{{ route('home') }}" class="btn-sm btn-outline" target="_blank">Lihat Website ↗</a>
                </div>
            </header>

            <main class="dash-content">
                <x-alert />
                @yield('content')
                @yield('dashboard')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>

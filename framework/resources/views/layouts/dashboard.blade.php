<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - FMIPA Lost & Found</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    @include('partials.navbar')

    <div class="dashboard-wrapper">
        <aside class="dashboard-sidebar">
            @if (auth()->check() && auth()->user()->isAdmin())
                @include('partials.sidebar.admin')
            @elseif (auth()->check() && auth()->user()->isPetugas())
                @include('partials.sidebar.petugas')
            @else
                @include('partials.sidebar.pengguna')
            @endif
        </aside>

        <main class="dashboard-main">
            <div class="dashboard-container">
                <x-alert />
                @yield('dashboard')
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>

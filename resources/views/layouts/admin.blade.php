<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Zerox Pharmaceuticals')</title>

    <!-- Dynamic Favicon Icons -->
    @php
        $faviconPath = \App\Models\SiteSetting::get('site_favicon', 'img/favicon.png');
        $faviconUrl = asset($faviconPath);
    @endphp
    <link rel="icon" type="image/png" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">

    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Chart.js for Graphical System Dashboard -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }

        .admin-sidebar {
            width: 260px;
            background: #0f172a;
            min-height: 100vh;
            color: #94a3b8;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
        }

        .admin-sidebar .brand {
            padding: 1.25rem;
            color: #ffffff;
            font-weight: 700;
            font-size: 1.1rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-sidebar .nav-link {
            color: #94a3b8;
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            border-radius: 6px;
            margin: 0.2rem 0.75rem;
            transition: all 0.2s;
        }

        .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active {
            color: #ffffff;
            background: #1e293b;
        }

        .admin-sidebar .nav-link i {
            font-size: 1.1rem;
            color: #38bdf8;
        }

        .admin-content {
            margin-left: 260px;
            padding: 2rem;
        }

        .admin-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 2rem;
            margin-left: 260px;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Admin Sidebar -->
    <div class="admin-sidebar">
        <div class="brand">
            <img src="{{ asset(\App\Models\SiteSetting::get('site_logo_header', \App\Models\SiteSetting::get('site_logo', 'img/logo.png'))) }}" alt="Zerox Logo" style="max-height: 32px; background: #000; padding: 2px 6px; border-radius: 4px;">
            <span>ZEROX ADMIN</span>
        </div>
        <div class="py-3">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i> Banners
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="bi bi-capsule"></i> Products & Gallery
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-folder2-open"></i> Categories
            </a>
            <a href="{{ route('admin.verifications.index') }}" class="nav-link {{ request()->routeIs('admin.verifications.*') ? 'active' : '' }}">
                <i class="bi bi-qr-code-scan"></i> Verifications
            </a>
            <a href="{{ route('admin.subscribers.index') }}" class="nav-link {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
                <i class="bi bi-envelope-check"></i> Subscribers
            </a>

            @if(Auth::user() && Auth::user()->hasRole('admin'))
                <div class="px-3 pt-3 pb-1 text-uppercase text-secondary fw-bold" style="font-size: 0.7rem;">System Administration</div>
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="bi bi-sliders"></i> Site Settings
                </a>
                <a href="{{ route('admin.performance.index') }}" class="nav-link {{ request()->routeIs('admin.performance.*') ? 'active' : '' }}">
                    <i class="bi bi-lightning-charge text-warning"></i> Site Performance
                </a>
                <a href="{{ route('admin.routes.index') }}" class="nav-link {{ request()->routeIs('admin.routes.*') ? 'active' : '' }}">
                    <i class="bi bi-signpost-split text-info"></i> Routes & DB Inspector
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Users & Roles
                </a>
            @endif

            <div class="mt-4 px-3">
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-light btn-sm w-100"><i class="bi bi-box-arrow-up-right me-1"></i> View Live Site</a>
            </div>
        </div>
    </div>

    <!-- Top Admin Bar -->
    <div class="admin-navbar d-flex justify-content-between align-items-center">
        <div>
            <h5 class="m-0 fw-bold">@yield('page_title', 'Dashboard')</h5>
        </div>
        <div class="d-flex align-items-center gap-3">
            @if((\App\Models\SiteSetting::get('site_under_maintenance', '0')) == '1')
                <span class="badge bg-warning text-dark"><i class="bi bi-tools me-1"></i> Maintenance Mode Active</span>
            @endif
            <span class="text-secondary small">Logged in as: <strong class="text-dark">{{ Auth::user()->name }}</strong> ({{ Auth::user()->roles->pluck('name')->implode(', ') }})</span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-power me-1"></i> Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Admin Content -->
    <div class="admin-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

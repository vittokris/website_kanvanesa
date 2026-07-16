<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kantin Kanvanesa') - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @include('layouts.partials.design-system')
    <style>
        :root { --sidebar-w: 264px; }

        body.admin-page {
            background:
                linear-gradient(90deg, var(--primary-dark) 0 var(--sidebar-w), transparent var(--sidebar-w)),
                var(--bg);
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--primary-dark);
            color: white;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 28px 24px 20px;
        }

        .sidebar-brand-main {
            display: flex;
            align-items: center;
            gap: .75rem;
            color: white;
            text-decoration: none;
        }

        .sidebar-brand h5 {
            margin: 0;
            color: white;
            font-size: 1rem;
            line-height: 1.2;
        }

        .sidebar-brand small {
            display: block;
            margin-top: .2rem;
            color: var(--on-dark-muted);
            font-weight: 700;
        }

        .sidebar-badge {
            display: inline-flex;
            width: fit-content;
            margin-top: 14px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgb(231 226 71 / .18);
            color: var(--on-dark-soft);
            font-size: .78rem;
            font-weight: 800;
        }

        .sidebar-nav {
            flex: 1;
            padding: 10px 14px 20px;
        }

        .sidebar-label {
            margin: 18px 10px 8px;
            color: var(--on-dark-muted);
            font-size: .76rem;
            font-weight: 800;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 42px;
            margin-bottom: 4px;
            padding: 10px 12px;
            border-radius: 10px;
            color: var(--on-dark-muted);
            text-decoration: none;
            font-weight: 700;
            transition: background-color 160ms ease, color 160ms ease, transform 160ms ease;
        }

        .sidebar-link i {
            width: 22px;
            text-align: center;
            font-size: 1rem;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            color: white;
            background: rgb(92 128 188 / .28);
            transform: translateX(2px);
        }

        .sidebar-link.active i { color: var(--accent); }

        .sidebar-footer {
            padding: 16px 14px 22px;
        }

        .logout-link {
            width: 100%;
            border: 0;
            background: transparent;
            text-align: left;
        }

        .main-wrap {
            min-height: 100vh;
            margin-left: var(--sidebar-w);
            display: flex;
            flex-direction: column;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            min-height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 14px 28px;
            background: rgb(255 255 255 / .94);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--line);
        }

        .topbar-title {
            margin: 0;
            color: var(--ink);
            font-size: 1.22rem;
            line-height: 1.1;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: var(--chili);
            color: var(--surface);
            font-family: var(--font-number);
            font-weight: 700;
            font-size: .88rem;
        }

        .main-wrap .main-content {
            width: min(100% - 56px, 1240px);
            padding: 28px 0 48px;
        }

        .stat-card {
            min-height: 144px;
            border-radius: var(--radius);
            padding: 22px;
            color: white;
            background: var(--leaf-dark);
            box-shadow: var(--shadow-soft);
        }

        .stat-card .stat-icon {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: rgb(252 255 243 / .14);
            font-size: 1.2rem;
        }

        .stat-card .stat-val {
            margin-top: 18px;
            font-family: var(--font-number);
            font-size: 2rem;
            line-height: 1;
            font-weight: 700;
        }

        .stat-card .stat-label {
            margin-top: 6px;
            color: var(--on-dark-muted);
            font-weight: 700;
        }

        .stat-card.stat-hot {
            background: var(--ash-soft);
            color: var(--charcoal);
        }
        .stat-card.stat-hot .stat-icon {
            background: rgb(92 128 188 / .18);
            color: var(--blue);
        }
        .stat-card.stat-hot .stat-label { color: var(--muted); }
        .stat-card.stat-gold {
            background: var(--accent);
            color: var(--charcoal);
        }
        .stat-card.stat-gold .stat-icon { background: rgb(61 59 48 / .12); }
        .stat-card.stat-gold .stat-label { color: var(--charcoal); }
        .stat-card.stat-ink { background: var(--ink); }

        @media (max-width: 900px) {
            body.admin-page {
                background: var(--bg);
            }

            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }

            .sidebar-nav {
                display: flex;
                gap: 8px;
                overflow-x: auto;
                padding: 10px 14px 14px;
            }

            .sidebar-label,
            .sidebar-footer,
            .sidebar-badge {
                display: none;
            }

            .sidebar-link {
                white-space: nowrap;
            }

            .main-wrap {
                margin-left: 0;
            }

            .topbar {
                position: static;
                padding: 14px 18px;
            }

            .main-wrap .main-content {
                width: min(100% - 24px, 1240px);
                padding-top: 20px;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="admin-page">

<aside class="sidebar">
    <div class="sidebar-brand">
        <a class="sidebar-brand-main" href="{{ route('admin.dashboard') }}">
            <span class="brand-mark"><i class="bi bi-egg-fried"></i></span>
            <span>
                <h5>Kantin Kanvanesa</h5>
                <small>Admin Panel</small>
            </span>
        </a>
        <span class="sidebar-badge">DSS - AHP &amp; SAW</span>
    </div>

    <nav class="sidebar-nav" aria-label="Navigasi admin">
        <div class="sidebar-label">Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-label">Manajemen</div>
        <a href="{{ route('admin.menus.index') }}" class="sidebar-link {{ request()->routeIs('admin.menus*') ? 'active' : '' }}">
            <i class="bi bi-journal-richtext"></i> Kelola Menu
        </a>

        <div class="sidebar-label">Analisis</div>
        <a href="{{ route('admin.ahp') }}" class="sidebar-link {{ request()->routeIs('admin.ahp') ? 'active' : '' }}">
            <i class="bi bi-diagram-3"></i> Bobot AHP
        </a>
        <a href="{{ route('admin.saw') }}" class="sidebar-link {{ request()->routeIs('admin.saw*') ? 'active' : '' }}">
            <i class="bi bi-trophy"></i> Perankingan SAW
        </a>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="sidebar-link logout-link">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </div>
</aside>

<div class="main-wrap">
    <header class="topbar">
        <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>
        <div class="topbar-user">
            <div class="avatar-circle">
                {{ strtoupper(substr(Auth::guard('web')->user()->admin_name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div style="font-size:.9rem;font-weight:800;color:var(--ink);">
                    {{ Auth::guard('web')->user()->admin_name ?? 'Admin' }}
                </div>
                <div style="font-size:.78rem;color:var(--muted);font-weight:700;">Administrator</div>
            </div>
        </div>
    </header>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>

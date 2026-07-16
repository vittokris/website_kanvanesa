<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kantin Kanvanesa')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @include('layouts.partials.design-system')
    <style>
        body.user-page {
            background: var(--bg);
        }

        .navbar-kanvanesa {
            min-height: 70px;
            padding: 12px 0;
            background: var(--leaf-dark);
            color: white;
        }

        .navbar-kanvanesa .container-fluid {
            width: min(100% - 32px, 1220px);
            padding: 0;
        }

        .brand-lockup {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            color: white !important;
            font-weight: 800;
            letter-spacing: 0;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-grid;
            place-items: center;
            background: var(--chili);
            color: white;
        }

        .navbar-kanvanesa .nav-link {
            color: var(--on-dark-muted) !important;
            border-radius: 999px;
            padding: 8px 13px;
            font-size: .92rem;
            font-weight: 700;
            transition: background-color 160ms ease, color 160ms ease;
        }

        .navbar-kanvanesa .nav-link:hover,
        .navbar-kanvanesa .nav-link.active {
            color: white !important;
            background: rgb(92 128 188 / .28);
        }

        .navbar-kanvanesa .navbar-toggler {
            border: 0;
            color: white;
            box-shadow: none;
        }

        .navbar-kanvanesa .navbar-toggler-icon {
            filter: invert(1);
        }

        .nav-action-row {
            display: flex;
            align-items: center;
            gap: .6rem;
            flex-wrap: wrap;
        }

        .nav-login {
            color: white;
            background: rgb(92 128 188 / .28);
        }

        .nav-login:hover {
            color: white;
            background: rgb(92 128 188 / .38);
        }

        .nav-register {
            background: var(--accent);
            color: var(--charcoal);
        }

        .nav-register:hover {
            background: var(--blue);
            color: white;
        }

        .account-menu-btn {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            min-height: 40px;
            padding: 8px 12px 8px 8px;
            border-radius: 999px;
            background: rgb(92 128 188 / .28);
            color: white;
            border: 0;
            font-weight: 700;
        }

        .account-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-grid;
            place-items: center;
            background: var(--accent);
            color: var(--charcoal);
            font-family: var(--font-number);
            font-size: .78rem;
        }

        .dropdown-menu {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 8px 22px rgb(61 59 48 / .14);
            padding: 8px;
        }

        .dropdown-item {
            border-radius: 8px;
            font-weight: 700;
            color: var(--ink);
        }

        .dropdown-item:hover {
            background: var(--leaf-soft);
            color: var(--leaf-dark);
        }

        @media (max-width: 991.98px) {
            .navbar-kanvanesa .container-fluid {
                width: min(100% - 20px, 1220px);
            }

            .navbar-collapse {
                padding-top: 14px;
            }

            .nav-action-row {
                padding-top: 10px;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="user-page">

<nav class="navbar navbar-expand-lg navbar-kanvanesa">
    <div class="container-fluid">
        <a class="navbar-brand brand-lockup" href="{{ route('ranking') }}">
            <span class="brand-mark"><i class="bi bi-egg-fried"></i></span>
            <span>Kantin Kanvanesa</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navUser" aria-controls="navUser" aria-expanded="false" aria-label="Buka navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navUser">
            <ul class="navbar-nav ms-lg-4 me-auto gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('ranking') ? 'active' : '' }}" href="{{ route('ranking') }}">
                        <i class="bi bi-trophy me-1"></i>Ranking Menu
                    </a>
                </li>
                @auth('user')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.penilaian*') ? 'active' : '' }}" href="{{ route('user.penilaian') }}">
                        <i class="bi bi-stars me-1"></i>Beri Penilaian
                    </a>
                </li>
                @endauth
            </ul>
            <div class="nav-action-row">
                @auth('user')
                    <div class="dropdown">
                        <button class="account-menu-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="account-avatar">
                                {{ strtoupper(substr(Auth::guard('user')->user()->user_name ?? 'U', 0, 1)) }}
                            </span>
                            <span>{{ Auth::guard('user')->user()->user_name ?? 'User' }}</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('user.penilaian') }}">
                                <i class="bi bi-star me-2"></i>Beri Penilaian
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm nav-login">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-sm nav-register">
                        <i class="bi bi-person-plus me-1"></i>Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>

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
        body.auth-page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 28px;
            background: var(--bg);
        }

        .auth-shell {
            width: min(100%, 460px);
            min-height: auto;
            border-radius: 14px;
            overflow: hidden;
            background: var(--surface);
            box-shadow: 0 10px 24px rgb(61 59 48 / .10);
            animation: page-rise 260ms cubic-bezier(.22, 1, .36, 1) both;
        }

        .auth-card {
            width: 100%;
            max-width: none;
            border-radius: inherit;
            box-shadow: none;
            background: var(--surface);
        }

        .auth-header {
            padding: 34px 38px 14px;
            text-align: left;
            background: transparent;
        }

        .auth-header .logo { display: none; }
        .auth-header h4 {
            margin: 0;
            color: var(--ink);
            font-size: 1.55rem;
            line-height: 1.15;
        }

        .auth-header p {
            margin: .55rem 0 0;
            color: var(--muted);
            font-size: .94rem;
        }

        .auth-body { padding: 20px 38px 26px; }

        .auth-footer {
            padding: 0 38px 34px;
            color: var(--muted);
            font-size: .9rem;
        }

        .auth-footer a {
            color: var(--primary);
            font-weight: 800;
            text-decoration: none;
        }

        .auth-footer a:hover { text-decoration: underline; }

        @media (max-width: 780px) {
            body.auth-page {
                padding: 16px;
                background: var(--bg);
            }

            .auth-shell {
                min-height: auto;
                border-radius: 14px;
            }
            .auth-header,
            .auth-body,
            .auth-footer {
                padding-left: 26px;
                padding-right: 26px;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="auth-page">
    <div class="auth-shell">
        @yield('content')
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>

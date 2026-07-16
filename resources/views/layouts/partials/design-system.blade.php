<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --font-ui: "Bricolage Grotesque", "Aptos", "Trebuchet MS", sans-serif;
        --font-number: "JetBrains Mono", "Cascadia Mono", "SFMono-Regular", monospace;
        --accent: #E7E247;
        --charcoal: #3D3B30;
        --slate: #4D5061;
        --blue: #5C80BC;
        --cream: #FCFFF3;
        --primary: var(--slate);
        --primary-dark: var(--charcoal);
        --ash: var(--blue);
        --ivory: var(--cream);
        --linen: #F7FAEA;
        --ink: #2E2D25;
        --muted: #4D5061;
        --subtle: #686B7A;
        --bg: var(--cream);
        --surface: #FFFFFF;
        --surface-2: #F4F7EA;
        --line: #E2E7D4;
        --on-dark-muted: #E8EAD7;
        --on-dark-soft: #FCFFF3;
        --primary-soft: #E8EEF8;
        --primary-hover: var(--charcoal);
        --ash-soft: #EEF3FA;
        --leaf: var(--primary);
        --leaf-dark: var(--primary-dark);
        --leaf-soft: var(--primary-soft);
        --chili: var(--blue);
        --chili-soft: var(--ash-soft);
        --gold: var(--accent);
        --success: #3D3B30;
        --success-soft: #EEF3FA;
        --danger: #B91C1C;
        --danger-soft: #FEE2E2;
        --warning: #3D3B30;
        --warning-soft: #F7F4A7;
        --info: var(--blue);
        --radius: 12px;
        --radius-sm: 8px;
        --shadow-soft: 0 1px 5px rgb(61 59 48 / 0.10);
    }

    * { box-sizing: border-box; }
    html { min-height: 100%; }
    body {
        margin: 0;
        min-height: 100vh;
        font-family: var(--font-ui);
        font-weight: 500;
        letter-spacing: 0;
        color: var(--ink);
        background: var(--bg);
        text-rendering: optimizeLegibility;
    }

    h1, h2, h3, h4, h5, h6 {
        color: var(--ink);
        font-weight: 800;
        letter-spacing: 0;
        text-wrap: balance;
    }

    p { text-wrap: pretty; }
    a { color: var(--leaf); }
    a:hover { color: var(--leaf-dark); }
    .text-muted { color: var(--muted) !important; }
    .font-number { font-family: var(--font-number); letter-spacing: 0; }

    .brand-mark {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-grid;
        place-items: center;
        background: var(--chili);
        color: var(--surface);
        flex: 0 0 auto;
    }

    .main-content {
        width: min(100% - 32px, 1220px);
        margin: 0 auto;
        padding: 28px 0 46px;
    }

    .main-content > * {
        animation: page-rise 220ms cubic-bezier(.22, 1, .36, 1) both;
    }

    .main-content > *:nth-child(2) { animation-delay: 45ms; }
    .main-content > *:nth-child(3) { animation-delay: 80ms; }

    @keyframes page-rise {
        from { opacity: .01; transform: translateY(10px); filter: blur(3px); }
        to { opacity: 1; transform: translateY(0); filter: blur(0); }
    }

    .card {
        border: 0;
        border-radius: var(--radius);
        background: var(--surface);
        box-shadow: var(--shadow-soft);
        overflow: hidden;
    }

    .card-header {
        background: var(--surface);
        border-bottom: 1px solid var(--line);
        border-radius: var(--radius) var(--radius) 0 0 !important;
        color: var(--ink);
        font-weight: 800;
        padding: 16px 20px;
    }

    .panel-flat {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow-soft);
    }

    .section-title {
        margin: 0;
        font-size: 1.1rem;
        line-height: 1.2;
        font-weight: 800;
    }

    .section-note {
        margin: .3rem 0 0;
        color: var(--muted);
        font-size: .91rem;
        max-width: 72ch;
    }

    .btn {
        border-radius: 10px;
        border: 0;
        font-weight: 700;
        letter-spacing: 0;
    }

    .btn-kanvanesa-primary,
    .btn-primary-custom {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        width: auto;
        min-height: 42px;
        padding: 10px 18px;
        background: var(--chili);
        color: var(--surface);
        border: 0;
        border-radius: 10px;
        font-weight: 800;
        text-decoration: none;
        transition: transform 160ms ease, background-color 160ms ease;
    }

    .btn-kanvanesa-primary:hover,
    .btn-primary-custom:hover {
        color: var(--surface);
        background: var(--primary-hover);
        transform: translateY(-1px);
    }

    .btn-primary-custom { width: 100%; }

    .btn-kanvanesa-ghost {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .45rem;
        min-height: 40px;
        padding: 9px 15px;
        background: var(--surface-2);
        color: var(--leaf-dark);
        text-decoration: none;
        transition: background-color 160ms ease, transform 160ms ease;
    }

    .btn-kanvanesa-ghost:hover {
        background: var(--leaf-soft);
        color: var(--leaf-dark);
        transform: translateY(-1px);
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .form-label {
        color: var(--ink);
        font-size: .84rem;
        font-weight: 800;
        letter-spacing: 0;
        margin-bottom: .45rem;
    }

    .form-control,
    .form-select {
        min-height: 42px;
        border: 1px solid var(--line);
        border-radius: 10px;
        color: var(--ink);
        background-color: var(--surface);
        font-weight: 500;
        transition: border-color 160ms ease, box-shadow 160ms ease;
    }

    .form-control::placeholder { color: var(--muted); opacity: 1; }
    .form-control:focus,
    .form-select:focus {
        border-color: var(--leaf);
        box-shadow: 0 0 0 3px rgb(92 128 188 / .18);
    }

    .form-check-label {
        color: var(--muted);
        font-size: .9rem;
        font-weight: 700;
    }

    .input-group-text {
        border: 1px solid var(--line);
        border-radius: 10px;
        color: var(--muted);
        background: var(--surface-2);
    }

    .alert {
        border: 0;
        border-radius: var(--radius-sm);
        font-weight: 600;
        box-shadow: none;
    }

    .alert-success { color: var(--success); background: var(--success-soft); }
    .alert-danger { color: var(--danger); background: var(--danger-soft); }
    .alert-warning { color: var(--warning); background: var(--warning-soft); }

    .table {
        color: var(--ink);
        margin-bottom: 0;
    }

    .table > thead > tr > th {
        background: var(--surface-2);
        color: var(--muted);
        border-bottom: 1px solid var(--line);
        font-size: .82rem;
        font-weight: 800;
        letter-spacing: 0;
        padding: 13px 16px;
        vertical-align: middle;
    }

    .table > tbody > tr > td {
        border-color: var(--line);
        padding: 13px 16px;
        vertical-align: middle;
        font-size: .91rem;
    }

    .table-hover > tbody > tr:hover { background: var(--surface-2); }

    .rank-badge {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-number);
        font-weight: 700;
        font-size: .84rem;
    }

    .rank-1 { background: var(--charcoal); color: var(--surface); }
    .rank-2 { background: var(--blue); color: var(--surface); }
    .rank-3 { background: var(--accent); color: var(--charcoal); }
    .rank-other { background: var(--leaf-soft); color: var(--leaf-dark); }

    .status-chip,
    .badge-soft {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        width: fit-content;
        border-radius: 999px;
        padding: 4px 10px;
        background: var(--leaf-soft);
        color: var(--leaf-dark);
        font-size: .78rem;
        font-weight: 800;
        letter-spacing: 0;
    }

    .badge-chili {
        background: var(--warning-soft);
        color: var(--charcoal);
    }

    .score-value {
        font-family: var(--font-number);
        font-size: 1.22rem;
        font-weight: 700;
        color: var(--leaf-dark);
        letter-spacing: 0;
    }

    .metric-tile {
        min-width: 128px;
        padding: 12px 14px;
        border-radius: 10px;
        background: var(--ash-soft);
        color: var(--primary-dark);
    }

    .metric-label {
        color: inherit;
        opacity: .78;
        font-size: .78rem;
        font-weight: 700;
    }

    .metric-number {
        font-family: var(--font-number);
        font-size: 1.45rem;
        font-weight: 700;
        line-height: 1.1;
        letter-spacing: 0;
    }

    .menu-thumb {
        width: 66px;
        height: 66px;
        object-fit: cover;
        border-radius: 10px;
        display: block;
        background: var(--surface-2);
    }

    .menu-thumb-placeholder {
        width: 66px;
        height: 66px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        background: var(--surface-2);
        color: var(--subtle);
    }

    .progress {
        background: var(--line);
        border-radius: 999px;
        overflow: hidden;
    }

    .progress-bar {
        background: var(--leaf);
        border-radius: inherit;
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            scroll-behavior: auto !important;
            transition-duration: .01ms !important;
        }
    }

    @media (max-width: 576px) {
        .main-content {
            width: min(100% - 20px, 1220px);
            padding-top: 18px;
        }

        .table-responsive-mobile {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }
</style>

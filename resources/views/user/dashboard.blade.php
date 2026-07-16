@extends('layouts.user')

@section('title', 'Dashboard - Kantin Kanvanesa')

@section('content')
<section class="user-hero">
    <div>
        <span class="status-chip badge-chili">Dashboard pengguna</span>
        <h1>Halo, {{ $user->user_name }}.</h1>
        <p>Ranking menu terbaru sudah siap dipindai. Beri penilaian baru untuk ikut mengubah posisi menu favorit.</p>
    </div>
    <div class="user-hero-actions">
        <div class="metric-tile">
            <div class="metric-label">Total menu</div>
            <div class="metric-number">{{ $menus }}</div>
        </div>
        <div class="metric-tile">
            <div class="metric-label">Diranking</div>
            <div class="metric-number">{{ $rankings->count() }}</div>
        </div>
        <a href="{{ route('user.penilaian') }}" class="btn-kanvanesa-primary">
            <i class="bi bi-stars"></i>Beri penilaian
        </a>
    </div>
</section>

@if($rankings->isEmpty())
    <section class="empty-state panel-flat">
        <i class="bi bi-clipboard-data"></i>
        <h2>Ranking belum tersedia</h2>
        <p>Berikan penilaian agar sistem punya data untuk menghitung skor SAW.</p>
        <a href="{{ route('user.penilaian') }}" class="btn-kanvanesa-primary">
            <i class="bi bi-star"></i>Beri penilaian
        </a>
    </section>
@else
    <section class="mini-ranking panel-flat">
        <header class="mini-ranking-header">
            <div>
                <h2 class="section-title">Peringkat Menu Favorit</h2>
                <p class="section-note">Skor akhir dari metode SAW.</p>
            </div>
            <a href="{{ route('user.penilaian') }}" class="btn-kanvanesa-ghost">
                <i class="bi bi-star"></i>Beri penilaian
            </a>
        </header>

        <div class="mini-ranking-list">
            @php $maxSkor = $rankings->max('skor'); @endphp
            @foreach($rankings as $i => $hasil)
            @php
                $rank = $i + 1;
                $scoreWidth = $maxSkor > 0 ? ($hasil->skor / $maxSkor) * 100 : 0;
            @endphp
            <article class="mini-ranking-row {{ $rank === 1 ? 'is-leader' : '' }}">
                <span class="rank-badge rank-{{ $rank <= 3 ? $rank : 'other' }}">{{ $rank }}</span>

                @if($hasil->menu?->menu_image)
                    <img src="{{ $hasil->menu->image_url }}" alt="{{ $hasil->menu->menu_name }}" class="menu-thumb">
                @else
                    <div class="menu-thumb-placeholder"><i class="bi bi-image"></i></div>
                @endif

                <div class="mini-menu-copy">
                    <div class="mini-title-line">
                        <h3>{{ $hasil->menu?->menu_name ?? '-' }}</h3>
                        @if($rank === 1)
                            <span class="status-chip badge-chili">Top pilihan</span>
                        @endif
                    </div>
                    @if($hasil->menu?->menu_description)
                        <p>{{ $hasil->menu->menu_description }}</p>
                    @endif
                    @if($hasil->menu)
                        <div class="menu-price"><i class="bi bi-cash-coin"></i>{{ $hasil->menu->formatted_price }}</div>
                    @endif
                    <div class="score-track" aria-hidden="true">
                        <span style="width: {{ $scoreWidth }}%;"></span>
                    </div>
                </div>

                <div class="score-column">
                    <div class="score-value">{{ number_format($hasil->skor, 3) }}</div>
                    <div class="score-label">skor final</div>
                </div>
            </article>
            @endforeach
        </div>
    </section>
@endif

@push('styles')
<style>
    .user-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 28px;
        align-items: end;
        margin-bottom: 28px;
        padding: 34px;
        border-radius: 14px;
        color: var(--ink);
        background: var(--surface);
        box-shadow: var(--shadow-soft);
    }

    .user-hero h1 {
        margin: 14px 0 10px;
        color: var(--primary-dark);
        font-size: 2.25rem;
        line-height: 1;
    }

    .user-hero p {
        max-width: 68ch;
        margin: 0;
        color: var(--muted);
    }

    .user-hero-actions {
        display: flex;
        align-items: end;
        justify-content: flex-end;
        gap: 12px;
        flex-wrap: wrap;
        max-width: 430px;
    }

    .mini-ranking {
        overflow: hidden;
    }

    .mini-ranking-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 20px 24px;
        border-bottom: 1px solid var(--line);
    }

    .mini-ranking-row {
        display: grid;
        grid-template-columns: 40px 74px minmax(0, 1fr) 124px;
        gap: 16px;
        align-items: start;
        padding: 18px 24px;
        border-bottom: 1px solid var(--line);
    }

    .mini-ranking-row:last-child { border-bottom: 0; }
    .mini-ranking-row.is-leader { background: var(--primary-soft); }

    .mini-title-line {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .mini-title-line h3 {
        margin: 0;
        color: var(--leaf-dark);
        font-size: 1.05rem;
        line-height: 1.2;
    }

    .mini-menu-copy p {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin: 6px 0 0;
        color: var(--muted);
        font-size: .88rem;
    }

    .menu-price {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 6px;
        color: var(--ink);
        font-weight: 800;
        font-size: .9rem;
    }

    .score-track {
        width: min(100%, 300px);
        height: 7px;
        margin-top: 12px;
        border-radius: 999px;
        background: var(--line);
        overflow: hidden;
    }

    .score-track span {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: var(--leaf);
    }

    .score-column {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 2px;
    }

    .score-label {
        color: var(--muted);
        font-size: .8rem;
        font-weight: 700;
    }

    .empty-state {
        display: grid;
        justify-items: center;
        gap: 10px;
        padding: 56px 24px;
        text-align: center;
    }

    .empty-state i {
        color: var(--leaf);
        font-size: 2.4rem;
    }

    .empty-state h2 {
        margin: 0;
        font-size: 1.28rem;
    }

    .empty-state p {
        max-width: 44ch;
        margin: 0 0 10px;
        color: var(--muted);
    }

    @media (max-width: 820px) {
        .user-hero {
            grid-template-columns: 1fr;
            padding: 26px;
        }

        .user-hero-actions {
            justify-content: flex-start;
            max-width: none;
        }

        .mini-ranking-row {
            grid-template-columns: 38px 66px minmax(0, 1fr);
        }

        .score-column {
            grid-column: 3;
            align-items: flex-start;
        }
    }

    @media (max-width: 576px) {
        .user-hero h1 { font-size: 1.75rem; }
        .mini-ranking-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .mini-ranking-row {
            grid-template-columns: 36px minmax(0, 1fr);
            padding: 18px;
        }

        .mini-ranking-row .menu-thumb,
        .mini-ranking-row .menu-thumb-placeholder {
            grid-column: 1 / -1;
            width: 100%;
            height: 170px;
        }

        .mini-menu-copy,
        .score-column {
            grid-column: 1 / -1;
        }
    }
</style>
@endpush

@endsection

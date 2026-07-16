@extends('layouts.user')

@section('title', 'Ranking Menu - Kantin Kanvanesa')

@section('content')
<section class="ranking-hero">
    <div>
        <span class="status-chip badge-chili">Ranking menu kantin</span>
        @auth('user')
            <h1>Halo, {{ Auth::guard('user')->user()->user_name }}.</h1>
            <p>Menu terbaik hari ini disusun dari penilaian pengguna dengan bobot AHP dan skor SAW.</p>
        @else
            <h1>Peringkat menu yang jelas sebelum memilih makan.</h1>
            <p>Lihat ranking menu Kantin Kanvanesa. Masuk untuk ikut memberi penilaian pada kriteria rasa, tampilan, harga, porsi, dan gizi.</p>
        @endauth
    </div>
    <div class="hero-side">
        <div class="metric-tile">
            <div class="metric-label">Total menu</div>
            <div class="metric-number">{{ $totalMenus }}</div>
        </div>
        <div class="metric-tile">
            <div class="metric-label">Sudah diranking</div>
            <div class="metric-number">{{ $rankings->count() }}</div>
        </div>
        @guest('user')
            <a href="{{ route('login') }}" class="btn-kanvanesa-primary">
                <i class="bi bi-star-fill"></i>Login untuk menilai
            </a>
        @endguest
        @auth('user')
            <a href="{{ route('user.penilaian') }}" class="btn-kanvanesa-primary">
                <i class="bi bi-star-fill"></i>Beri penilaian
            </a>
        @endauth
    </div>
</section>

@if($rankings->isEmpty())
    <section class="empty-state panel-flat">
        <i class="bi bi-bar-chart"></i>
        <h2>Ranking belum tersedia</h2>
        <p>Belum ada penilaian masuk. Jadilah yang pertama memberi nilai pada menu kantin.</p>
        @guest('user')
            <a href="{{ route('login') }}" class="btn-kanvanesa-primary">
                <i class="bi bi-box-arrow-in-right"></i>Login untuk menilai
            </a>
        @else
            <a href="{{ route('user.penilaian') }}" class="btn-kanvanesa-primary">
                <i class="bi bi-star"></i>Beri penilaian
            </a>
        @endguest
    </section>
@else
    <section class="ranking-board">
        <header class="board-header">
            <div>
                <h2 class="section-title">Peringkat Menu Favorit</h2>
                <p class="section-note">Berdasarkan metode SAW + AHP.</p>
            </div>
            <span class="status-chip">{{ $rankings->count() }} menu</span>
        </header>

        <div class="ranking-list">
            @php $maxSkor = $rankings->max('skor'); @endphp
            @foreach($rankings as $i => $hasil)
            @php
                $rank = $i + 1;
                $scoreWidth = $maxSkor > 0 ? ($hasil->skor / $maxSkor) * 100 : 0;
            @endphp
            <article class="ranking-row {{ $rank === 1 ? 'is-leader' : '' }}">
                <div class="rank-column">
                    <span class="rank-badge rank-{{ $rank <= 3 ? $rank : 'other' }}">{{ $rank }}</span>
                </div>

                <div class="menu-media">
                    @if($hasil->menu?->menu_image)
                        <img src="{{ $hasil->menu->image_url }}" alt="{{ $hasil->menu->menu_name }}" class="menu-thumb">
                    @else
                        <div class="menu-thumb-placeholder"><i class="bi bi-image"></i></div>
                    @endif
                </div>

                <div class="menu-copy">
                    <div class="menu-line">
                        <h3>{{ $hasil->menu?->menu_name ?? '-' }}</h3>
                        @if($rank === 1)
                            <span class="status-chip badge-chili">Top pilihan</span>
                        @endif
                    </div>
                    @if($hasil->menu)
                        <div class="menu-price">
                            <i class="bi bi-cash-coin"></i>{{ $hasil->menu->formatted_price }}
                        </div>
                    @endif

                    @if(isset($menuScores[$hasil->id_menu]))
                    <div class="criteria-grid">
                        @foreach($kriterias as $kriteria)
                        @php
                            $score = $menuScores[$hasil->id_menu][$kriteria->id_kriteria] ?? null;
                            $stars = $score ? $score['rounded'] : 0;
                            $subName = $score ? $score['sub_name'] : 'Belum dinilai';
                        @endphp
                        <div class="criteria-line">
                            <span class="criteria-name">{{ $kriteria->kriteria_name }}</span>
                            <span class="star-row" aria-label="{{ $stars }} dari 5">
                                @for($s = 1; $s <= 5; $s++)
                                    <i class="bi {{ $s <= $stars ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </span>
                            <span class="criteria-sub">{{ $stars > 0 ? $subName : 'Belum dinilai' }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="score-track" aria-hidden="true">
                        <span style="width: {{ $scoreWidth }}%;"></span>
                    </div>
                </div>

                <div class="score-column">
                    <div class="score-value">{{ number_format($hasil->skor, 3) }}</div>
                    <div class="score-label">skor SAW</div>
                </div>
            </article>
            @endforeach
        </div>
    </section>
@endif

@push('styles')
<style>
    .ranking-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 28px;
        align-items: end;
        margin-bottom: 28px;
        padding: 34px;
        border-radius: 14px;
        background: var(--surface);
        color: var(--ink);
        box-shadow: var(--shadow-soft);
        overflow: hidden;
    }

    .ranking-hero h1 {
        max-width: 720px;
        margin: 14px 0 10px;
        color: var(--primary-dark);
        font-size: 2.3rem;
        line-height: 1;
    }

    .ranking-hero p {
        max-width: 72ch;
        margin: 0;
        color: var(--muted);
        font-size: 1rem;
    }

    .hero-side {
        display: flex;
        align-items: end;
        justify-content: flex-end;
        gap: 12px;
        flex-wrap: wrap;
        max-width: 430px;
    }

    .ranking-board {
        overflow: hidden;
        border-radius: 14px;
        background: var(--surface);
        box-shadow: var(--shadow-soft);
    }

    .board-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 20px 24px;
        border-bottom: 1px solid var(--line);
    }

    .ranking-row {
        display: grid;
        grid-template-columns: 44px 78px minmax(0, 1fr) 124px;
        gap: 18px;
        padding: 22px 24px;
        border-bottom: 1px solid var(--line);
        transition: background-color 160ms ease;
    }

    .ranking-row:last-child { border-bottom: 0; }
    .ranking-row:hover { background: var(--surface-2); }
    .ranking-row.is-leader { background: var(--primary-soft); }

    .rank-column,
    .menu-media,
    .score-column {
        display: flex;
        align-items: flex-start;
    }

    .rank-column { justify-content: center; padding-top: 2px; }
    .score-column {
        flex-direction: column;
        align-items: flex-end;
        gap: 2px;
    }

    .score-label {
        color: var(--muted);
        font-size: .8rem;
        font-weight: 700;
    }

    .menu-line {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        min-width: 0;
    }

    .menu-line h3 {
        margin: 0;
        color: var(--leaf-dark);
        font-size: 1.08rem;
        line-height: 1.2;
    }

    .menu-price {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 6px;
        color: var(--ink);
        font-weight: 800;
        font-size: .92rem;
    }

    .criteria-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(230px, 1fr));
        gap: 6px 22px;
        margin-top: 12px;
        max-width: 720px;
    }

    .criteria-line {
        display: grid;
        grid-template-columns: 132px 78px minmax(0, 1fr);
        align-items: center;
        gap: 8px;
        min-width: 0;
        color: var(--muted);
        font-size: .84rem;
    }

    .criteria-name {
        color: var(--ink);
        font-weight: 800;
    }

    .star-row {
        display: inline-flex;
        gap: 2px;
        color: var(--primary);
        font-size: .82rem;
        line-height: 1;
    }

    .star-row .bi-star { color: var(--ash); }

    .criteria-sub {
        min-width: 0;
        overflow: hidden;
        color: var(--muted);
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .score-track {
        width: min(100%, 360px);
        height: 7px;
        margin-top: 14px;
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

    @media (max-width: 900px) {
        .ranking-hero {
            grid-template-columns: 1fr;
            padding: 26px;
        }

        .hero-side {
            justify-content: flex-start;
            max-width: none;
        }

        .ranking-row {
            grid-template-columns: 40px 66px minmax(0, 1fr);
        }

        .score-column {
            grid-column: 3;
            align-items: flex-start;
        }

        .criteria-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .ranking-hero h1 { font-size: 1.75rem; }
        .ranking-row {
            grid-template-columns: 36px minmax(0, 1fr);
            gap: 12px;
            padding: 18px;
        }

        .menu-media {
            grid-column: 1 / -1;
        }

        .menu-thumb,
        .menu-thumb-placeholder {
            width: 100%;
            height: 170px;
        }

        .menu-copy,
        .score-column {
            grid-column: 1 / -1;
        }

        .criteria-line {
            grid-template-columns: 1fr;
            gap: 4px;
        }

        .board-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush

@endsection

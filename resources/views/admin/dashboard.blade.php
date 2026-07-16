@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<section class="admin-intro">
    <div>
        <h2>Data kantin, penilaian, dan ranking dalam satu layar.</h2>
    </div>
    <a href="{{ route('admin.menus.index') }}" class="btn-kanvanesa-primary">
        <i class="bi bi-plus-lg"></i>Tambah menu
    </a>
</section>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-journal-richtext"></i></div>
            <div class="stat-val">{{ $stats['total_menu'] }}</div>
            <div class="stat-label">Total Menu</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-hot">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div class="stat-val">{{ $stats['total_user'] }}</div>
            <div class="stat-label">Total Pengguna</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-gold">
            <div class="stat-icon"><i class="bi bi-star"></i></div>
            <div class="stat-val">{{ $stats['total_penilaian'] }}</div>
            <div class="stat-label">Total Penilaian</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-ink">
            <div class="stat-icon"><i class="bi bi-trophy"></i></div>
            <div class="stat-val">{{ $stats['total_hasil'] }}</div>
            <div class="stat-label">Hasil SAW</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <section class="panel-flat overflow-hidden">
            <header class="admin-panel-header">
                <div>
                    <h2 class="section-title">Top 5 Peringkat Menu</h2>
                    <p class="section-note">Menu dengan skor SAW tertinggi.</p>
                </div>
                @if($topMenus->isEmpty())
                    <span class="status-chip">Belum ada data</span>
                @else
                    <a href="{{ route('admin.saw') }}" class="btn-kanvanesa-ghost">
                        <i class="bi bi-arrow-right"></i>Lihat semua
                    </a>
                @endif
            </header>
            @if($topMenus->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-bar-chart"></i>
                    <h3>Belum ada hasil kalkulasi</h3>
                    <p>Ranking akan terisi otomatis setelah ada penilaian pengguna.</p>
                </div>
            @else
                <div class="table-responsive-mobile">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Menu</th>
                                <th>Skor SAW</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topMenus as $i => $hasil)
                            <tr>
                                <td>
                                    <span class="rank-badge rank-{{ $i < 3 ? $i+1 : 'other' }}">{{ $i+1 }}</span>
                                </td>
                                <td><strong>{{ $hasil->menu->menu_name ?? '-' }}</strong></td>
                                <td><span class="score-value">{{ number_format($hasil->skor, 3) }}</span></td>
                                <td style="min-width:150px;">
                                    <div class="progress" style="height:8px;">
                                        <div class="progress-bar" style="width:{{ $hasil->skor * 100 }}%;"></div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>

    <div class="col-lg-5">
        <section class="panel-flat action-panel">
            <header class="admin-panel-header">
                <div>
                    <h2 class="section-title">Aksi Cepat</h2>
                    <p class="section-note">Jalur pendek untuk tugas admin yang paling sering.</p>
                </div>
            </header>
            <div class="action-list">
                <a href="{{ route('admin.menus.index') }}" class="action-item">
                    <span><i class="bi bi-plus-circle"></i></span>
                    <strong>Tambah atau edit menu</strong>
                    <small>Kelola nama, harga, deskripsi, dan foto menu.</small>
                </a>
                <a href="{{ route('admin.ahp') }}" class="action-item">
                    <span><i class="bi bi-diagram-3"></i></span>
                    <strong>Lihat bobot AHP</strong>
                    <small>Periksa bobot kriteria yang dipakai sistem.</small>
                </a>
                <a href="{{ route('admin.saw') }}" class="action-item action-primary">
                    <span><i class="bi bi-trophy"></i></span>
                    <strong>Pantau ranking SAW</strong>
                    <small>Ranking diperbarui otomatis dari penilaian.</small>
                </a>
            </div>
        </section>
    </div>
</div>

@push('styles')
<style>
    .admin-intro {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 22px;
    }

    .admin-intro h2 {
        max-width: 760px;
        margin: 0;
        font-size: 1.65rem;
        line-height: 1.1;
    }

    .admin-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border-bottom: 1px solid var(--line);
    }

    .empty-state {
        display: grid;
        justify-items: center;
        gap: 8px;
        padding: 48px 24px;
        text-align: center;
    }

    .empty-state i {
        color: var(--leaf);
        font-size: 2.2rem;
    }

    .empty-state h3 {
        margin: 0;
        font-size: 1.08rem;
    }

    .empty-state p {
        margin: 0;
        color: var(--muted);
    }

    .action-panel {
        height: 100%;
        overflow: hidden;
    }

    .action-list {
        display: grid;
        gap: 10px;
        padding: 18px;
    }

    .action-item {
        display: grid;
        grid-template-columns: 42px 1fr;
        gap: 2px 12px;
        padding: 14px;
        border-radius: 12px;
        color: var(--ink);
        text-decoration: none;
        background: var(--surface-2);
        transition: background-color 160ms ease, transform 160ms ease;
    }

    .action-item:hover {
        color: var(--ink);
        background: var(--leaf-soft);
        transform: translateY(-1px);
    }

    .action-item span {
        grid-row: span 2;
        width: 42px;
        height: 42px;
        display: grid;
        place-items: center;
        border-radius: 10px;
        background: var(--leaf-dark);
        color: white;
    }

    .action-item strong {
        font-size: .98rem;
        line-height: 1.2;
    }

    .action-item small {
        color: var(--muted);
        font-weight: 600;
    }

    .action-primary {
        background: var(--leaf-dark);
        color: white;
    }

    .action-primary:hover {
        background: var(--leaf-dark);
        color: white;
    }

    .action-primary span {
        background: var(--chili);
    }

    .action-primary small {
        color: var(--on-dark-muted);
    }

    .action-primary span {
        background: var(--accent);
        color: var(--charcoal);
    }

    @media (max-width: 700px) {
        .admin-intro,
        .admin-panel-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush
@endsection

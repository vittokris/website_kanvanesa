@extends('layouts.admin')

@section('title', 'Perankingan SAW')
@section('page-title', 'Perankingan SAW')

@section('content')
<section class="saw-intro">
    <div>
        <span class="status-chip badge-chili">Ranking otomatis</span>
        <h2>Hasil perankingan menu berdasarkan SAW.</h2>
        <p>Bobot AHP diterapkan pada setiap kriteria. Ranking diperbarui otomatis saat penilaian baru tersimpan.</p>
    </div>
    @if($hasData && !$results->isEmpty())
        <div class="last-updated">
            <span>Dihitung terakhir</span>
            <strong>{{ $results->first()?->updated_at?->format('d M Y, H:i') ?? '-' }}</strong>
        </div>
    @endif
</section>

@if(!$hasData)
    <section class="empty-state panel-flat">
        <i class="bi bi-clipboard-x"></i>
        <h2>Belum ada data penilaian</h2>
        <p>Ranking belum dapat dihitung karena pengguna belum mengirim penilaian.</p>
    </section>
@elseif($results->isEmpty())
    <div class="alert alert-warning">
        <i class="bi bi-info-circle-fill me-2"></i>
        Data penilaian tersedia namun ranking belum terhitung. Silakan tunggu hingga sistem memproses data secara otomatis.
    </div>
@else
    <section class="panel-flat saw-panel">
        <header class="admin-panel-header">
            <div>
                <h2 class="section-title">Hasil Perankingan SAW</h2>
            </div>
            <span class="status-chip">{{ $results->count() }} menu</span>
        </header>
        <div class="table-responsive-mobile">
            <table class="table table-hover saw-table">
                <thead>
                    <tr>
                        <th style="width:80px;">Peringkat</th>
                        <th style="width:82px;">Foto</th>
                        <th>Nama Menu</th>
                        <th style="width:150px;">Skor SAW</th>
                        <th style="width:280px;">Visualisasi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $maxSkor = (float) $results->max('skor'); @endphp
                    @foreach($results as $i => $hasil)
                    @php
                        $skor = (float) $hasil->skor;
                        $scoreWidth = $maxSkor > 0 ? ($skor / $maxSkor) * 100 : 0;
                    @endphp
                    <tr>
                        <td>
                            <span class="rank-badge rank-{{ $i < 3 ? $i+1 : 'other' }}">{{ $i+1 }}</span>
                        </td>
                        <td>
                            @if($hasil->menu?->menu_image)
                                <img src="{{ $hasil->menu->image_url }}" alt="{{ $hasil->menu->menu_name }}" class="menu-thumb">
                            @else
                                <div class="menu-thumb-placeholder"><i class="bi bi-image"></i></div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $hasil->menu?->menu_name ?? '-' }}</strong>
                            @if($i === 0)
                                <span class="status-chip ms-2">Skor tertinggi</span>
                            @endif
                        </td>
                        <td><span class="score-value">{{ number_format($skor, 3) }}</span></td>
                        <td>
                            <div class="score-track" aria-label="Visualisasi {{ number_format($scoreWidth, 1) }} persen dari nilai tertinggi">
                                <span style="width: {{ $scoreWidth }}%;"></span>
                            </div>
                            <small class="score-caption">
                                {{ number_format($scoreWidth, 1) }}% dari nilai tertinggi
                            </small>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel-flat breakdown-panel">
        <header class="admin-panel-header">
            <div>
                <h2 class="section-title">Detail Kontribusi Skor</h2>
                <p class="section-note">Bagian ini menjelaskan dari mana skor SAW berasal: rata-rata penilaian, normalisasi, bobot AHP, lalu kontribusi tiap kriteria.</p>
            </div>
        </header>

        <div class="breakdown-list">
            @foreach($results as $i => $hasil)
                @php
                    $detail = $calculation['byMenu'][$hasil->id_menu] ?? null;
                    $skor = (float) $hasil->skor;
                @endphp
                @if($detail)
                    <details class="breakdown-item" {{ $i === 0 ? 'open' : '' }}>
                        <summary>
                            <span class="rank-badge rank-{{ $i < 3 ? $i+1 : 'other' }}">{{ $i+1 }}</span>
                            <span class="summary-main">
                                <strong>{{ $hasil->menu?->menu_name ?? '-' }}</strong>
                                <small>Total skor = jumlah seluruh kontribusi kriteria</small>
                            </span>
                            <span class="summary-score">{{ number_format($skor, 3) }}</span>
                        </summary>

                        <div class="criterion-grid">
                            @foreach($detail['criteria'] as $criterion)
                                @php
                                    $normalizedPercent = min(max($criterion['normalized'] * 100, 0), 100);
                                @endphp
                                <article class="criterion-detail">
                                    <div class="criterion-head">
                                        <span>{{ $criterion['name'] }}</span>
                                        <strong>+{{ number_format($criterion['contribution'], 3) }}</strong>
                                    </div>
                                    <div class="criterion-track">
                                        <span style="width: {{ $normalizedPercent }}%;"></span>
                                    </div>
                                    <div class="criterion-metrics">
                                        <div>
                                            <small>Rata-rata</small>
                                            <strong>{{ number_format($criterion['raw'], 3) }}</strong>
                                        </div>
                                        <div>
                                            <small>Max kriteria</small>
                                            <strong>{{ number_format($criterion['max'], 3) }}</strong>
                                        </div>
                                        <div>
                                            <small>Normalisasi</small>
                                            <strong>{{ number_format($criterion['normalized'], 3) }}</strong>
                                        </div>
                                        <div>
                                            <small>Bobot AHP</small>
                                            <strong>{{ number_format($criterion['weight'], 3) }}</strong>
                                        </div>
                                    </div>
                                    <p>
                                        {{ number_format($criterion['normalized'], 3) }}
                                        x {{ number_format($criterion['weight'], 3) }}
                                        = {{ number_format($criterion['contribution'], 3) }}
                                    </p>
                                </article>
                            @endforeach
                        </div>
                    </details>
                @endif
            @endforeach
        </div>
    </section>
@endif

<section class="panel-flat ahp-reference">
    <header class="admin-panel-header">
        <div>
            <h2 class="section-title">Bobot AHP yang Digunakan</h2>
            <p class="section-note">Referensi bobot untuk perhitungan skor akhir. Semua kriteria dihitung sebagai benefit.</p>
        </div>
    </header>
    <div class="weight-cards">
        @forelse($calculation['kriterias'] as $kriteria)
            @php $weight = $calculation['weights'][$kriteria->kriteria_name] ?? 0; @endphp
            <div class="weight-card">
                <span>{{ $kriteria->kriteria_name }}</span>
                <strong>{{ number_format($weight, 3) }}</strong>
                <small>Benefit</small>
            </div>
        @empty
            <p class="section-note px-3 py-3 mb-0">Data kriteria belum tersedia.</p>
        @endforelse
    </div>
    <div class="score-reading-grid">
        <div class="reading-tile">
            <span>Normalisasi</span>
            <strong>r = nilai / max</strong>
            <p>Nilai menu dibandingkan dengan nilai rata-rata tertinggi pada kriteria yang sama.</p>
        </div>
        <div class="reading-tile">
            <span>Kontribusi</span>
            <strong>r x bobot</strong>
            <p>Semakin besar kontribusinya, semakin besar pengaruh kriteria itu pada skor akhir.</p>
        </div>
    </div>
    <div class="formula-note">
        <strong>Rumus SAW:</strong> r = rata-rata nilai menu / rata-rata nilai tertinggi pada kriteria yang sama. Skor akhir = jumlah dari r x bobot AHP.
    </div>
</section>

@push('styles')
<style>
    .saw-intro {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 22px;
        padding: 28px;
        border-radius: 14px;
        color: var(--ink);
        background: var(--surface);
        box-shadow: var(--shadow-soft);
    }

    .saw-intro h2 {
        max-width: 760px;
        margin: 12px 0 8px;
        color: var(--primary-dark);
        font-size: 1.8rem;
        line-height: 1.08;
    }

    .saw-intro p {
        margin: 0;
        color: var(--muted);
    }

    .last-updated {
        min-width: 190px;
        display: grid;
        justify-items: end;
        gap: 4px;
    }

    .last-updated span {
        color: var(--muted);
        font-weight: 700;
    }

    .last-updated strong {
        color: var(--primary-dark);
        font-size: 1.05rem;
    }

    .saw-panel,
    .breakdown-panel,
    .ahp-reference {
        overflow: hidden;
        margin-bottom: 22px;
    }

    .admin-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border-bottom: 1px solid var(--line);
    }

    .score-track {
        width: 100%;
        height: 10px;
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

    .score-caption {
        display: grid;
        gap: 1px;
        margin-top: 6px;
        color: var(--muted);
        font-weight: 700;
        line-height: 1.2;
    }

    .score-caption span {
        color: var(--subtle);
        font-size: .78rem;
    }

    .score-reading-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 12px;
        padding: 18px 20px;
        border-bottom: 1px solid var(--line);
        background: var(--surface);
    }

    .reading-tile {
        min-height: 118px;
        display: grid;
        align-content: start;
        gap: 6px;
        padding: 14px;
        border-radius: 10px;
        background: var(--surface-2);
    }

    .reading-tile span {
        color: var(--muted);
        font-size: .82rem;
        font-weight: 800;
    }

    .reading-tile strong {
        color: var(--leaf-dark);
        font-family: var(--font-number);
        font-size: 1.08rem;
        line-height: 1.2;
    }

    .reading-tile p {
        max-width: 42ch;
        margin: 0;
        color: var(--muted);
        font-size: .88rem;
        line-height: 1.35;
    }

    .breakdown-list {
        display: grid;
    }

    .breakdown-item {
        border-bottom: 1px solid var(--line);
    }

    .breakdown-item:last-child {
        border-bottom: 0;
    }

    .breakdown-item summary {
        display: flex;
        align-items: center;
        gap: 14px;
        min-height: 76px;
        padding: 16px 20px;
        cursor: pointer;
        list-style: none;
        transition: background-color 160ms ease;
    }

    .breakdown-item summary::-webkit-details-marker {
        display: none;
    }

    .breakdown-item summary:hover {
        background: var(--surface-2);
    }

    .summary-main {
        min-width: 0;
        flex: 1;
        display: grid;
        gap: 2px;
    }

    .summary-main strong {
        color: var(--ink);
        line-height: 1.25;
    }

    .summary-main small {
        color: var(--muted);
        font-weight: 700;
    }

    .summary-score {
        color: var(--leaf-dark);
        font-family: var(--font-number);
        font-size: 1.18rem;
        font-weight: 700;
    }

    .criterion-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 12px;
        padding: 0 20px 20px 68px;
    }

    .criterion-detail {
        min-height: 232px;
        display: grid;
        align-content: start;
        gap: 12px;
        padding: 14px;
        border: 1px solid var(--line);
        border-radius: 10px;
        background: var(--surface);
    }

    .criterion-head {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .criterion-head span {
        color: var(--ink);
        font-weight: 800;
        line-height: 1.2;
    }

    .criterion-head strong {
        color: var(--leaf-dark);
        font-family: var(--font-number);
        white-space: nowrap;
    }

    .criterion-track {
        width: 100%;
        height: 8px;
        border-radius: 999px;
        background: var(--line);
        overflow: hidden;
    }

    .criterion-track span {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: var(--blue);
    }

    .criterion-metrics {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
    }

    .criterion-metrics div {
        min-height: 54px;
        display: grid;
        align-content: center;
        gap: 2px;
        padding: 8px;
        border-radius: 8px;
        background: var(--surface-2);
    }

    .criterion-metrics small {
        color: var(--muted);
        font-size: .74rem;
        font-weight: 800;
        line-height: 1.15;
    }

    .criterion-metrics strong {
        color: var(--ink);
        font-family: var(--font-number);
        font-size: .9rem;
        line-height: 1.2;
    }

    .criterion-detail p {
        margin: 0;
        color: var(--muted);
        font-family: var(--font-number);
        font-size: .8rem;
        font-weight: 700;
        line-height: 1.35;
    }

    .weight-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
        padding: 18px 20px;
    }

    .weight-card {
        display: grid;
        gap: 4px;
        padding: 14px;
        border-radius: 12px;
        background: var(--surface-2);
    }

    .weight-card span {
        color: var(--leaf-dark);
        font-weight: 800;
        line-height: 1.2;
    }

    .weight-card strong {
        color: var(--ink);
        font-family: var(--font-number);
        font-size: 1.35rem;
        line-height: 1;
    }

    .weight-card small {
        color: var(--muted);
        font-weight: 800;
    }

    .formula-note {
        padding: 0 20px 20px;
        color: var(--muted);
        font-size: .9rem;
    }

    .empty-state {
        display: grid;
        justify-items: center;
        gap: 10px;
        margin-bottom: 22px;
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
        max-width: 48ch;
        margin: 0;
        color: var(--muted);
    }

    @media (max-width: 760px) {
        .saw-intro,
        .admin-panel-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .last-updated {
            justify-items: start;
        }

        .criterion-grid {
            padding-left: 20px;
        }

        .breakdown-item summary {
            align-items: flex-start;
        }
    }

    @media (max-width: 520px) {
        .breakdown-item summary {
            flex-wrap: wrap;
        }

        .summary-score {
            width: 100%;
            padding-left: 48px;
        }
    }
</style>
@endpush
@endsection

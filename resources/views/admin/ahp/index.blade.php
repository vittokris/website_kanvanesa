@extends('layouts.admin')

@section('title', 'Bobot AHP')
@section('page-title', 'Analytic Hierarchy Process')

@section('content')
<section class="method-intro">
    <div>
        <span class="status-chip badge-chili">Bobot final</span>
        <h2>Prioritas kriteria untuk menghitung ranking menu.</h2>
        <p>Nilai AHP bersifat statis dan dipakai sebagai bobot pada proses SAW.</p>
    </div>
    <div class="consistency-mini">
        <span>CR</span>
        <strong>0.099</strong>
        <small>Konsisten</small>
    </div>
</section>

@php
    $bobotSummary = [
        ['name' => 'Rasa', 'bobot' => 0.358],
        ['name' => 'Tampilan Penyajian', 'bobot' => 0.233],
        ['name' => 'Harga', 'bobot' => 0.192],
        ['name' => 'Porsi', 'bobot' => 0.112],
        ['name' => 'Gizi', 'bobot' => 0.105],
    ];
@endphp

<section class="weights-panel panel-flat">
    <header class="admin-panel-header">
        <div>
            <h2 class="section-title">Ringkasan bobot vektor</h2>
            <p class="section-note">Semakin besar bobot, semakin kuat pengaruhnya pada skor akhir.</p>
        </div>
    </header>
    <div class="weight-list">
        @foreach($bobotSummary as $b)
        <article class="weight-card">
            <span>{{ $b['name'] }}</span>
            <strong>{{ number_format($b['bobot'], 3) }}</strong>
        </article>
        @endforeach
    </div>
</section>

<section class="ahp-panel panel-flat">
    <header class="admin-panel-header">
        <div>
            <h2 class="section-title">Skala Kepentingan Kriteria</h2>
            <p class="section-note">Nilai perbandingan antar kriteria.</p>
        </div>
    </header>
    <div class="table-responsive-mobile">
        <table class="table table-hover ahp-table">
            <thead>
                <tr>
                    <th style="width:60px;">No</th>
                    <th>Kriteria</th>
                    <th>Terhadap</th>
                    <th class="text-center" style="width:100px;">Bobot</th>
                </tr>
            </thead>
            <tbody>
                <tr><td rowspan="4" class="text-center fw-bold">1</td><td rowspan="4" class="fw-bold">Rasa</td><td>Tampilan Penyajian</td><td class="text-center font-number">3</td></tr>
                <tr><td>Harga</td><td class="text-center font-number">2</td></tr>
                <tr><td>Porsi</td><td class="text-center font-number">3</td></tr>
                <tr><td>Gizi</td><td class="text-center font-number">2</td></tr>
                <tr><td rowspan="3" class="text-center fw-bold">2</td><td rowspan="3" class="fw-bold">Tampilan Penyajian</td><td>Harga</td><td class="text-center font-number">2</td></tr>
                <tr><td>Porsi</td><td class="text-center font-number">3</td></tr>
                <tr><td>Gizi</td><td class="text-center font-number">2</td></tr>
                <tr><td rowspan="2" class="text-center fw-bold">3</td><td rowspan="2" class="fw-bold">Harga</td><td>Porsi</td><td class="text-center font-number">2</td></tr>
                <tr><td>Gizi</td><td class="text-center font-number">3</td></tr>
                <tr><td class="text-center fw-bold">4</td><td class="fw-bold">Porsi</td><td>Gizi</td><td class="text-center font-number">2</td></tr>
                <tr><td class="text-center fw-bold">5</td><td class="fw-bold">Gizi</td><td class="text-muted">Tidak dibandingkan</td><td class="text-center text-muted">-</td></tr>
            </tbody>
        </table>
    </div>
</section>

<section class="ahp-panel panel-flat">
    <header class="admin-panel-header">
        <div>
            <h2 class="section-title">Matriks Perbandingan Berpasangan</h2>
            <p class="section-note">Matriks asal sebelum normalisasi.</p>
        </div>
    </header>
    <div class="table-responsive-mobile">
        <table class="table table-hover ahp-table matrix-table">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <th class="text-center">Rasa</th>
                    <th class="text-center">Tampilan Penyajian</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Porsi</th>
                    <th class="text-center">Gizi</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="fw-bold">Rasa</td><td class="text-center diag">1.000</td><td class="text-center">3.000</td><td class="text-center">2.000</td><td class="text-center">3.000</td><td class="text-center">2.000</td></tr>
                <tr><td class="fw-bold">Tampilan Penyajian</td><td class="text-center">0.333</td><td class="text-center diag">1.000</td><td class="text-center">2.000</td><td class="text-center">3.000</td><td class="text-center">2.000</td></tr>
                <tr><td class="fw-bold">Harga</td><td class="text-center">0.500</td><td class="text-center">0.500</td><td class="text-center diag">1.000</td><td class="text-center">3.000</td><td class="text-center">2.000</td></tr>
                <tr><td class="fw-bold">Porsi</td><td class="text-center">0.333</td><td class="text-center">0.333</td><td class="text-center">0.333</td><td class="text-center diag">1.000</td><td class="text-center">2.000</td></tr>
                <tr><td class="fw-bold">Gizi</td><td class="text-center">0.500</td><td class="text-center">0.500</td><td class="text-center">0.500</td><td class="text-center">0.500</td><td class="text-center diag">1.000</td></tr>
            </tbody>
            <tfoot>
                <tr><td class="fw-bold">Jumlah</td><td class="text-center">2.667</td><td class="text-center">5.333</td><td class="text-center">5.833</td><td class="text-center">10.500</td><td class="text-center">9.000</td></tr>
            </tfoot>
        </table>
    </div>
</section>

<section class="ahp-panel panel-flat">
    <header class="admin-panel-header">
        <div>
            <h2 class="section-title">Matriks Ternormalisasi &amp; Bobot Vektor</h2>
            <p class="section-note">Nilai bobot akhir diperoleh dari rata-rata setiap baris.</p>
        </div>
    </header>
    <div class="table-responsive-mobile">
        <table class="table table-hover ahp-table matrix-table">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <th class="text-center">Rasa</th>
                    <th class="text-center">Tampilan Penyajian</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Porsi</th>
                    <th class="text-center">Gizi</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Bobot Vektor</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="fw-bold">Rasa</td><td class="text-center">0.375</td><td class="text-center">0.563</td><td class="text-center">0.343</td><td class="text-center">0.286</td><td class="text-center">0.222</td><td class="text-center muted-sum">1.788</td><td class="text-center vector">0.358</td></tr>
                <tr><td class="fw-bold">Tampilan Penyajian</td><td class="text-center">0.125</td><td class="text-center">0.188</td><td class="text-center">0.343</td><td class="text-center">0.286</td><td class="text-center">0.222</td><td class="text-center muted-sum">1.163</td><td class="text-center vector">0.233</td></tr>
                <tr><td class="fw-bold">Harga</td><td class="text-center">0.188</td><td class="text-center">0.094</td><td class="text-center">0.171</td><td class="text-center">0.286</td><td class="text-center">0.222</td><td class="text-center muted-sum">0.961</td><td class="text-center vector">0.192</td></tr>
                <tr><td class="fw-bold">Porsi</td><td class="text-center">0.125</td><td class="text-center">0.063</td><td class="text-center">0.057</td><td class="text-center">0.095</td><td class="text-center">0.222</td><td class="text-center muted-sum">0.562</td><td class="text-center vector">0.112</td></tr>
                <tr><td class="fw-bold">Gizi</td><td class="text-center">0.188</td><td class="text-center">0.094</td><td class="text-center">0.086</td><td class="text-center">0.048</td><td class="text-center">0.111</td><td class="text-center muted-sum">0.526</td><td class="text-center vector">0.105</td></tr>
            </tbody>
            <tfoot>
                <tr><td colspan="6" class="text-end fw-bold">Total Bobot Vektor</td><td colspan="2" class="text-center vector">1.000</td></tr>
            </tfoot>
        </table>
    </div>
</section>

<section class="consistency-panel panel-flat">
    <header class="admin-panel-header">
        <div>
            <h2 class="section-title">Uji Konsistensi</h2>
            <p class="section-note">CR di bawah 0.1 berarti matriks layak dipakai.</p>
        </div>
    </header>
    <div class="consistency-grid">
        <div><span>n</span><strong>5</strong><small>Jumlah kriteria</small></div>
        <div><span>RI</span><strong>1.12</strong><small>Random index</small></div>
        <div><span>Lambda maks</span><strong>5.442</strong><small>Nilai maksimum</small></div>
        <div><span>CI</span><strong>0.110</strong><small>(lambda maks - n) / (n - 1)</small></div>
    </div>
    <div class="consistency-result">
        <div>
            <span>CR = CI / RI</span>
            <strong>0.099</strong>
        </div>
        <p><strong>Konsisten.</strong> CR = 0.099 &lt; 0.1, sehingga bobot AHP valid untuk perhitungan SAW.</p>
    </div>
</section>

@push('styles')
<style>
    .method-intro {
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

    .method-intro h2 {
        max-width: 780px;
        margin: 12px 0 8px;
        color: var(--primary-dark);
        font-size: 1.8rem;
        line-height: 1.08;
    }

    .method-intro p {
        margin: 0;
        color: var(--muted);
    }

    .consistency-mini {
        min-width: 132px;
        display: grid;
        justify-items: end;
    }

    .consistency-mini span,
    .consistency-mini small {
        color: var(--muted);
        font-weight: 800;
    }

    .consistency-mini strong {
        color: var(--primary-dark);
        font-family: var(--font-number);
        font-size: 2rem;
        line-height: 1;
    }

    .weights-panel,
    .ahp-panel,
    .consistency-panel {
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

    .weight-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
        padding: 18px 20px;
    }

    .weight-card {
        min-height: 86px;
        display: grid;
        align-content: center;
        gap: 4px;
        padding: 14px;
        border-radius: 10px;
        background: var(--surface-2);
    }

    .weight-card span {
        color: var(--leaf-dark);
        font-weight: 800;
        line-height: 1.2;
    }

    .weight-card strong {
        font-family: var(--font-number);
        font-size: 1.28rem;
        font-weight: 700;
        color: var(--ink);
        line-height: 1;
    }

    .ahp-table td,
    .ahp-table th {
        white-space: nowrap;
    }

    .matrix-table td:not(:first-child),
    .matrix-table th:not(:first-child) {
        font-family: var(--font-number);
        font-size: .84rem;
    }

    .matrix-table tfoot td {
        background: var(--surface-2);
        font-weight: 800;
    }

    .diag {
        background: var(--leaf-soft) !important;
        color: var(--leaf-dark);
        font-weight: 800;
    }

    .muted-sum {
        background: var(--surface-2) !important;
        font-weight: 800;
    }

    .vector {
        color: var(--leaf-dark);
        font-weight: 800;
        background: var(--leaf-soft) !important;
    }

    .consistency-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(140px, 1fr));
        gap: 1px;
        background: var(--line);
    }

    .consistency-grid div {
        display: grid;
        gap: 4px;
        padding: 20px;
        background: var(--surface);
    }

    .consistency-grid span,
    .consistency-grid small {
        color: var(--muted);
        font-weight: 700;
    }

    .consistency-grid strong {
        font-family: var(--font-number);
        font-size: 1.55rem;
        color: var(--ink);
    }

    .consistency-result {
        display: grid;
        grid-template-columns: 170px minmax(0, 1fr);
        gap: 20px;
        align-items: center;
        padding: 22px;
        background: var(--leaf-soft);
    }

    .consistency-result span {
        color: var(--muted);
        font-weight: 800;
    }

    .consistency-result strong {
        color: var(--leaf-dark);
    }

    .consistency-result > div strong {
        display: block;
        font-family: var(--font-number);
        font-size: 2.1rem;
        line-height: 1;
    }

    .consistency-result p {
        margin: 0;
        color: var(--ink);
    }

    @media (max-width: 760px) {
        .method-intro,
        .admin-panel-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .consistency-mini {
            justify-items: start;
        }

        .consistency-grid {
            grid-template-columns: 1fr 1fr;
        }

        .consistency-result {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
@endsection

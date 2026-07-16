@extends('layouts.admin')

@section('title', 'Hasil Kalkulasi SAW')
@section('page-title', 'Hasil Kalkulasi SAW')

@section('content')
<div class="alert alert-success result-alert">
    <i class="bi bi-check-circle-fill me-2"></i>
    <strong>Kalkulasi SAW berhasil.</strong> Hasil disimpan ke tabel <code>hasil_tb</code> dan diurutkan dari skor tertinggi.
</div>

<section class="panel-flat result-panel">
    <header class="admin-panel-header">
        <div>
            <h2 class="section-title">Peringkat Akhir SAW</h2>
            <p class="section-note">Nilai mentah, normalisasi, dan skor akhir per menu.</p>
        </div>
    </header>
    <div class="table-responsive-mobile">
        <table class="table table-hover calc-table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Menu</th>
                    @foreach($kriterias as $k)<th>{{ $k->kriteria_name }}</th>@endforeach
                    <th>Skor Akhir (V)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detail as $i => $row)
                @php $rank = array_search($i, array_keys($detail)) + 1; @endphp
                <tr>
                    <td>
                        <span class="rank-badge rank-{{ $rank <= 3 ? $rank : 'other' }}">{{ $rank }}</span>
                    </td>
                    <td><strong>{{ $row['menu']->menu_name }}</strong></td>
                    @foreach($kriterias as $k)
                        <td>
                            <span class="raw-value">{{ $row['raw'][$k->id_kriteria] }}</span>
                            <small>{{ number_format($row['normalized'][$k->id_kriteria],4) }}</small>
                        </td>
                    @endforeach
                    <td><span class="score-value">{{ number_format($row['skor'], 3) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<section class="panel-flat formula-panel">
    <header class="admin-panel-header">
        <div>
            <h2 class="section-title">Bobot &amp; Formula yang Digunakan</h2>
            <p class="section-note">Referensi kriteria pada proses normalisasi.</p>
        </div>
    </header>
    <div class="table-responsive-mobile">
        <table class="table table-hover formula-table">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <th>Bobot (W)</th>
                    <th>Tipe</th>
                    <th>Formula Normalisasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriterias as $k)
                @php $a = $ahpData[$k->kriteria_name] ?? ['weight'=>0,'type'=>'benefit']; @endphp
                <tr>
                    <td><strong>{{ $k->kriteria_name }}</strong></td>
                    <td><span class="font-number fw-bold">{{ number_format($a['weight'],3) }}</span></td>
                    <td><span class="status-chip">{{ ucfirst($a['type']) }}</span></td>
                    <td>{{ $a['type'] === 'benefit' ? 'r = nilai / 5' : 'r = 1 / nilai' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="formula-actions">
        <a href="{{ route('admin.saw') }}" class="btn-kanvanesa-ghost">
            <i class="bi bi-arrow-left"></i>Kembali ke SAW
        </a>
    </div>
</section>

@push('styles')
<style>
    .result-alert {
        margin-bottom: 20px;
    }

    .result-panel,
    .formula-panel {
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

    .calc-table td,
    .calc-table th,
    .formula-table td,
    .formula-table th {
        white-space: nowrap;
    }

    .raw-value {
        display: block;
        color: var(--leaf-dark);
        font-family: var(--font-number);
        font-weight: 700;
    }

    .calc-table small {
        color: var(--muted);
        font-family: var(--font-number);
        font-weight: 600;
    }

    .formula-actions {
        padding: 18px 20px;
        border-top: 1px solid var(--line);
    }

    @media (max-width: 760px) {
        .admin-panel-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush
@endsection

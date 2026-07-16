@extends('layouts.user')

@section('title', 'Beri Penilaian - Kantin Kanvanesa')

@section('content')
<header class="page-intro">
    <div>
        <span class="status-chip badge-chili">Penilaian menu</span>
        <h1>Beri nilai menu kantin.</h1>
        <p>Pilih satu menu, lalu isi setiap kriteria. Setiap nilai ikut mempengaruhi ranking akhir.</p>
    </div>
</header>

@if($menus->isEmpty())
    <section class="empty-state panel-flat">
        <i class="bi bi-journal-x"></i>
        <h2>Belum ada menu tersedia</h2>
        <p>Silakan hubungi admin untuk menambahkan menu kantin terlebih dahulu.</p>
    </section>
@else
<section class="menu-picker panel-flat">
    <header class="picker-header">
        <div>
            <h2 class="section-title">Pilih menu</h2>
            <p class="section-note">Menu yang sudah pernah Anda nilai tetap bisa dipilih untuk memperbarui pilihan.</p>
        </div>
        <span class="status-chip">{{ $menus->count() }} menu</span>
    </header>

    <div class="menu-grid" id="menuGrid">
        @foreach($menus as $menu)
        <button type="button"
            class="menu-card {{ in_array($menu->id_menu, $ratedMenuIds) ? 'rated' : '' }}"
            data-menu-id="{{ $menu->id_menu }}"
            data-menu-name="{{ $menu->menu_name }}">
            <span class="menu-card-media">
                @if($menu->menu_image)
                    <img src="{{ $menu->image_url }}" alt="{{ $menu->menu_name }}">
                @else
                    <span class="menu-card-placeholder"><i class="bi bi-image"></i></span>
                @endif
                @if(in_array($menu->id_menu, $ratedMenuIds))
                    <span class="rated-chip"><i class="bi bi-check2"></i>Sudah dinilai</span>
                @endif
            </span>
            <span class="menu-card-copy">
                <span class="menu-card-title">{{ $menu->menu_name }}</span>
                @if($menu->menu_description)
                    <span class="menu-card-desc">{{ $menu->menu_description }}</span>
                @endif
            </span>
        </button>
        @endforeach
    </div>
</section>

<section class="rating-panel panel-flat d-none" id="ratingForm">
    <header class="rating-header">
        <div>
            <h2 class="section-title">Nilai menu</h2>
            <p class="section-note">Menu terpilih: <strong id="selectedMenuName"></strong></p>
        </div>
    </header>

    <form method="POST" action="{{ route('user.penilaian.store') }}" id="ratingFormEl">
        @csrf
        <input type="hidden" name="id_menu" id="hiddenMenuId">

        <div class="criteria-stack">
            @foreach($kriterias as $kriteria)
            <fieldset class="criteria-block">
                <legend>
                    <span class="criteria-number">{{ $loop->iteration }}</span>
                    <span>{{ $kriteria->kriteria_name }}</span>
                </legend>

                <div class="rating-options">
                    @foreach($kriteria->subKriterias->sortBy('bobot_subkriteria') as $sub)
                    <div>
                        <input type="radio"
                            name="ratings[{{ $kriteria->id_kriteria }}]"
                            id="sub_{{ $kriteria->id_kriteria }}_{{ $sub->id_sub_kriteria }}"
                            value="{{ $sub->id_sub_kriteria }}"
                            class="btn-check"
                            required>
                        <label class="rating-option" for="sub_{{ $kriteria->id_kriteria }}_{{ $sub->id_sub_kriteria }}">
                            <span class="rating-weight">{{ $sub->bobot_subkriteria }}</span>
                            <span>{{ $sub->sub_kriteria_name }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>
            </fieldset>
            @endforeach
        </div>

        <div class="form-actions">
            <button type="button" class="btn-kanvanesa-ghost" id="cancelRating">
                <i class="bi bi-x-lg"></i>Batal
            </button>
            <button type="submit" class="btn-kanvanesa-primary">
                <i class="bi bi-send-check"></i>Simpan penilaian
            </button>
        </div>
    </form>
</section>
@endif

@push('styles')
<style>
    .page-intro {
        margin-bottom: 24px;
        padding: 30px;
        border-radius: 14px;
        color: var(--ink);
        background: var(--surface);
        box-shadow: var(--shadow-soft);
    }

    .page-intro h1 {
        margin: 14px 0 8px;
        color: var(--primary-dark);
        font-size: 2.25rem;
        line-height: 1;
    }

    .page-intro p {
        max-width: 70ch;
        margin: 0;
        color: var(--muted);
    }

    .menu-picker,
    .rating-panel {
        overflow: hidden;
        margin-bottom: 24px;
    }

    .picker-header,
    .rating-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 20px 24px;
        border-bottom: 1px solid var(--line);
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        padding: 22px;
    }

    .menu-card {
        display: grid;
        grid-template-rows: 170px auto;
        min-height: 332px;
        padding: 0;
        overflow: hidden;
        border: 0;
        border-radius: 12px;
        background: var(--surface-2);
        text-align: left;
        box-shadow: inset 0 0 0 1px var(--line);
        cursor: pointer;
        transition: transform 160ms ease, box-shadow 160ms ease, background-color 160ms ease;
    }

    .menu-card:hover,
    .menu-card:focus-visible {
        transform: translateY(-2px);
        background: white;
        box-shadow: inset 0 0 0 2px var(--leaf), var(--shadow-soft);
        outline: none;
    }

    .menu-card.selected {
        background: var(--leaf-soft);
        box-shadow: inset 0 0 0 2px var(--leaf);
    }

    .menu-card.rated .menu-card-title::after {
        content: "";
        display: inline-block;
        width: 7px;
        height: 7px;
        margin-left: 8px;
        border-radius: 50%;
        background: var(--success);
        vertical-align: middle;
    }

    .menu-card-media {
        position: relative;
        display: block;
        background: var(--surface-2);
        overflow: hidden;
    }

    .menu-card-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        padding: 0;
    }

    .menu-card-placeholder {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        color: var(--subtle);
        font-size: 2rem;
    }

    .rated-chip {
        position: absolute;
        top: 10px;
        right: 10px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        border-radius: 999px;
        padding: 5px 9px;
        background: var(--leaf-dark);
        color: white;
        font-size: .76rem;
        font-weight: 800;
    }

    .menu-card-copy {
        display: grid;
        align-content: start;
        gap: 8px;
        padding: 16px;
        min-height: 154px;
    }

    .menu-card-title {
        color: var(--leaf-dark);
        font-size: 1rem;
        font-weight: 800;
        line-height: 1.25;
    }

    .menu-card-desc {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: var(--muted);
        font-size: .86rem;
        line-height: 1.45;
    }

    .criteria-stack {
        display: grid;
        gap: 18px;
        padding: 24px;
    }

    .criteria-block {
        min-width: 0;
        margin: 0;
        padding: 0 0 18px;
        border: 0;
        border-bottom: 1px solid var(--line);
    }

    .criteria-block:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .criteria-block legend {
        display: flex;
        align-items: center;
        gap: 10px;
        width: auto;
        margin-bottom: 12px;
        color: var(--ink);
        font-size: 1rem;
        font-weight: 800;
    }

    .criteria-number {
        width: 30px;
        height: 30px;
        display: inline-grid;
        place-items: center;
        border-radius: 50%;
        background: var(--leaf-dark);
        color: white;
        font-family: var(--font-number);
        font-size: .82rem;
    }

    .rating-options {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .rating-option {
        min-width: 134px;
        min-height: 56px;
        display: grid;
        align-content: center;
        gap: 2px;
        padding: 9px 12px;
        border-radius: 10px;
        background: var(--surface-2);
        color: var(--ink);
        font-weight: 800;
        cursor: pointer;
        box-shadow: inset 0 0 0 1px var(--line);
        transition: background-color 160ms ease, box-shadow 160ms ease, color 160ms ease;
    }

    .rating-weight {
        color: var(--muted);
        font-family: var(--font-number);
        font-size: .78rem;
        line-height: 1;
    }

    .rating-option:hover {
        background: var(--leaf-soft);
        box-shadow: inset 0 0 0 1px var(--leaf);
    }

    .btn-check:checked + .rating-option {
        background: var(--leaf-dark);
        color: white;
        box-shadow: inset 0 0 0 2px var(--leaf-dark);
    }

    .btn-check:checked + .rating-option .rating-weight {
        color: var(--on-dark-muted);
    }

    .form-actions {
        display: flex;
        gap: 12px;
        padding: 0 24px 24px;
    }

    .form-actions .btn-kanvanesa-primary {
        flex: 1;
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
        margin: 0;
        color: var(--muted);
    }

    @media (max-width: 576px) {
        .page-intro {
            padding: 24px;
        }

        .page-intro h1 {
            font-size: 1.75rem;
        }

        .picker-header,
        .rating-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .menu-grid,
        .criteria-stack {
            padding: 16px;
        }

        .rating-option {
            min-width: 100%;
        }

        .form-actions {
            flex-direction: column;
            padding: 0 16px 16px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
let selectedCard = null;

document.querySelectorAll('.menu-card').forEach(card => {
    card.addEventListener('click', () => selectMenu(card));
});

document.getElementById('cancelRating')?.addEventListener('click', cancelSelection);

function selectMenu(card) {
    if (selectedCard) selectedCard.classList.remove('selected');
    selectedCard = card;
    card.classList.add('selected');

    document.getElementById('hiddenMenuId').value = card.dataset.menuId;
    document.getElementById('selectedMenuName').textContent = card.dataset.menuName;
    document.getElementById('ratingForm').classList.remove('d-none');
    document.getElementById('ratingForm').scrollIntoView({ behavior: 'smooth', block: 'start' });
    document.querySelectorAll('input[type=radio]').forEach(r => r.checked = false);
}

function cancelSelection() {
    if (selectedCard) selectedCard.classList.remove('selected');
    selectedCard = null;
    document.getElementById('ratingForm').classList.add('d-none');
    document.getElementById('ratingFormEl').reset();
}
</script>
@endpush
@endsection

@extends('layouts.admin')

@section('title', 'Edit Menu')
@section('page-title', 'Edit Menu')

@section('content')
<section class="edit-shell">
    <div class="edit-preview panel-flat">
        <a href="{{ route('admin.menus.index') }}" class="btn-kanvanesa-ghost back-link">
            <i class="bi bi-arrow-left"></i>Kembali
        </a>
        <div class="preview-media">
            @if($menu->menu_image)
                <img src="{{ $menu->image_url }}" alt="{{ $menu->menu_name }}">
            @else
                <div><i class="bi bi-image"></i></div>
            @endif
        </div>
        <div class="preview-copy">
            <h2>{{ $menu->menu_name }}</h2>
            @if($menu->menu_description)
                <p>{{ $menu->menu_description }}</p>
            @else
                <p>Menu ini belum memiliki deskripsi.</p>
            @endif
            <strong>{{ $menu->formatted_price }}</strong>
        </div>
    </div>

    <div class="panel-flat edit-form-panel">
        <header class="edit-header">
            <div>
                <h2 class="section-title">Perbarui detail menu</h2>
                <p class="section-note">Perubahan akan muncul pada ranking dan form penilaian.</p>
            </div>
        </header>

        <div class="edit-body">
            @if($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.menus.update', $menu->id_menu) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label" for="menu_name">Nama menu</label>
                    <input type="text" name="menu_name" id="menu_name" class="form-control"
                        value="{{ old('menu_name', $menu->menu_name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="menu_description">Deskripsi menu <span class="text-muted fw-semibold">(opsional)</span></label>
                    <textarea name="menu_description" id="menu_description" class="form-control" rows="4"
                        placeholder="Deskripsikan menu ini."
                        maxlength="1000">{{ old('menu_description', $menu->menu_description) }}</textarea>
                    <small class="text-muted">Maks. 1000 karakter.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="menu_price">Harga menu <span class="text-muted fw-semibold">(opsional)</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="menu_price" id="menu_price" class="form-control"
                            value="{{ old('menu_price', $menu->menu_price) }}" min="0" step="100"
                            placeholder="Contoh: 25000">
                    </div>
                    <small class="text-muted">Isi angka saja, contoh: 25000.</small>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="menu_image">Gambar menu</label>
                    <input type="file" name="menu_image" id="menu_image" class="form-control" accept="image/*">
                    <small class="text-muted">Upload gambar baru untuk mengganti foto saat ini. Format JPG, PNG, WEBP. Maks 2MB.</small>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.menus.index') }}" class="btn-kanvanesa-ghost">
                        <i class="bi bi-arrow-left"></i>Kembali
                    </a>
                    <button type="submit" class="btn-kanvanesa-primary">
                        <i class="bi bi-check2"></i>Simpan perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('styles')
<style>
    .edit-shell {
        display: grid;
        grid-template-columns: minmax(260px, 380px) minmax(0, 1fr);
        gap: 24px;
        align-items: start;
    }

    .edit-preview,
    .edit-form-panel {
        overflow: hidden;
    }

    .back-link {
        margin: 18px 18px 0;
    }

    .preview-media {
        margin: 18px;
        border-radius: 12px;
        overflow: hidden;
        background: var(--surface-2);
        aspect-ratio: 4 / 3;
    }

    .preview-media img,
    .preview-media div {
        width: 100%;
        height: 100%;
    }

    .preview-media img {
        object-fit: cover;
        display: block;
    }

    .preview-media div {
        display: grid;
        place-items: center;
        color: var(--subtle);
        font-size: 2.2rem;
    }

    .preview-copy {
        padding: 0 22px 24px;
    }

    .preview-copy h2 {
        margin: 14px 0 8px;
        color: var(--leaf-dark);
        font-size: 1.45rem;
        line-height: 1.12;
    }

    .preview-copy p {
        margin: 0 0 12px;
        color: var(--muted);
    }

    .preview-copy strong {
        display: inline-flex;
        border-radius: 999px;
        background: var(--leaf-soft);
        color: var(--leaf-dark);
        padding: 6px 11px;
    }

    .edit-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--line);
    }

    .edit-body {
        padding: 24px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .form-actions .btn-kanvanesa-primary {
        flex: 1;
    }

    @media (max-width: 900px) {
        .edit-shell {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
@endsection

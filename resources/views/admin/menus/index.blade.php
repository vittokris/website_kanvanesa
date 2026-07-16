@extends('layouts.admin')

@section('title', 'Kelola Menu')
@section('page-title', 'Kelola Menu')

@section('content')
<section class="admin-intro">
    <div>
        <span class="status-chip badge-chili">Manajemen menu</span>
        <h2>Tambah, edit, atau arsipkan menu kantin.</h2>
        <p>Data ini tampil pada ranking publik dan form penilaian pengguna.</p>
    </div>
    <button class="btn-kanvanesa-primary" data-bs-toggle="modal" data-bs-target="#addMenuModal">
        <i class="bi bi-plus-lg"></i>Tambah menu
    </button>
</section>

<section class="panel-flat menu-admin-panel">
    <header class="admin-panel-header">
        <div>
            <h2 class="section-title">Daftar Menu</h2>
            <p class="section-note">{{ $menus->count() }} item tersedia.</p>
        </div>
    </header>

    @if($menus->isEmpty())
        <div class="empty-state">
            <i class="bi bi-journal-x"></i>
            <h3>Belum ada menu</h3>
            <p>Klik tombol tambah menu untuk memulai katalog kantin.</p>
        </div>
    @else
        <div class="table-responsive-mobile">
            <table class="table table-hover menu-table">
                <thead>
                    <tr>
                        <th style="width:56px;">#</th>
                        <th style="width:86px;">Foto</th>
                        <th>Nama Menu</th>
                        <th style="width:140px;">Harga</th>
                        <th>Deskripsi</th>
                        <th style="width:130px;">Ditambahkan</th>
                        <th class="text-end" style="width:70px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $i => $menu)
                    <tr>
                        <td><span class="font-number">{{ $i+1 }}</span></td>
                        <td>
                            @if($menu->menu_image)
                                <img src="{{ $menu->image_url }}" alt="{{ $menu->menu_name }}" class="menu-thumb">
                            @else
                                <div class="menu-thumb-placeholder"><i class="bi bi-image"></i></div>
                            @endif
                        </td>
                        <td><strong>{{ $menu->menu_name }}</strong></td>
                        <td><span class="price-pill">{{ $menu->formatted_price }}</span></td>
                        <td class="description-cell">
                            @if($menu->menu_description)
                                <span>{{ $menu->menu_description }}</span>
                            @else
                                <span class="text-muted">Tidak ada deskripsi</span>
                            @endif
                        </td>
                        <td>{{ $menu->created_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <div class="dropdown">
                                <button class="btn btn-icon btn-kanvanesa-ghost" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Aksi menu {{ $menu->menu_name }}">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('admin.menus.edit', $menu->id_menu) }}" class="dropdown-item">
                                        <i class="bi bi-pencil me-2"></i>Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.menus.destroy', $menu->id_menu) }}"
                                        class="m-0"
                                        onsubmit="return confirm('Hapus menu ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-trash me-2"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>

<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content menu-modal">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="addMenuModalLabel">Tambah menu baru</h5>
                    <p>Lengkapi detail menu yang akan tampil di ranking.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form method="POST" action="{{ route('admin.menus.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label" for="menu_name">Nama menu</label>
                        <input type="text" name="menu_name" id="menu_name" class="form-control"
                            value="{{ old('menu_name') }}" placeholder="Contoh: Nasi Goreng Spesial" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="menu_description">Deskripsi menu <span class="text-muted fw-semibold">(opsional)</span></label>
                        <textarea name="menu_description" id="menu_description" class="form-control" rows="3"
                            placeholder="Deskripsikan bahan, rasa, atau porsi menu."
                            maxlength="1000">{{ old('menu_description') }}</textarea>
                        <small class="text-muted">Maks. 1000 karakter.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="menu_price">Harga menu <span class="text-muted fw-semibold">(opsional)</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="menu_price" id="menu_price" class="form-control"
                                value="{{ old('menu_price') }}" min="0" step="100"
                                placeholder="Contoh: 25000">
                        </div>
                        <small class="text-muted">Isi angka saja, contoh: 25000.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="imageInput">Gambar menu</label>
                        <input type="file" name="menu_image" class="form-control" accept="image/*" id="imageInput">
                        <div id="imagePreview" class="image-preview mt-3 d-none"></div>
                        <small class="text-muted">Format: JPG, PNG, WEBP. Maks 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-kanvanesa-ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-kanvanesa-primary">
                        <i class="bi bi-check2"></i>Simpan menu
                    </button>
                </div>
            </form>
        </div>
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
        margin: 12px 0 6px;
        font-size: 1.65rem;
        line-height: 1.1;
    }

    .admin-intro p {
        margin: 0;
        color: var(--muted);
    }

    .menu-admin-panel {
        overflow: hidden;
    }

    .admin-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border-bottom: 1px solid var(--line);
    }

    .description-cell {
        max-width: 280px;
        color: var(--muted);
    }

    .description-cell span {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .price-pill {
        display: inline-flex;
        border-radius: 999px;
        background: var(--leaf-soft);
        color: var(--leaf-dark);
        padding: 5px 10px;
        font-weight: 800;
        white-space: nowrap;
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

    .menu-modal {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
    }

    .menu-modal .modal-header,
    .menu-modal .modal-footer {
        border-color: var(--line);
        padding: 18px 22px;
    }

    .menu-modal .modal-title {
        font-weight: 800;
        color: var(--ink);
    }

    .menu-modal .modal-header p {
        margin: 4px 0 0;
        color: var(--muted);
        font-size: .9rem;
    }

    .menu-modal .modal-body {
        padding: 22px;
    }

    .image-preview img {
        width: 160px;
        height: 112px;
        object-fit: cover;
        border-radius: 10px;
        display: block;
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

@push('scripts')
<script>
document.getElementById('imageInput')?.addEventListener('change', event => {
    const file = event.target.files?.[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = `<img src="${e.target.result}" alt="Preview gambar menu">`;
        preview.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
});

@if($errors->any())
    const addMenuModal = new bootstrap.Modal(document.getElementById('addMenuModal'));
    addMenuModal.show();
@endif
</script>
@endpush
@endsection

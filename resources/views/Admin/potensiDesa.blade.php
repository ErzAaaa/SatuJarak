@extends('layouts.app')

@section('title', 'Kelola Potensi Desa')
@section('topbar_title', 'ADMIN · POTENSI DESA')
@section('active_menu', 'potensi')

@push('styles')
    <style>
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            height: 100%;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .stat-icon.mint {
            background: var(--mint-soft);
            color: #2D9B6A;
        }

        .stat-icon.gold {
            background: var(--gold-light);
            color: var(--peach-text);
        }

        .stat-icon.pink {
            background: var(--pink-light);
            color: var(--pink-text);
        }

        .stat-icon.forest {
            background: var(--forest);
            color: var(--mint);
        }

        .stat-value {
            font-size: 22px;
            font-weight: 800;
            color: var(--forest);
            line-height: 1.1;
        }

        .stat-label {
            font-size: 12.5px;
            color: var(--muted);
            font-weight: 600;
        }

        .toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .toolbar-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            flex: 1;
            min-width: 0;
        }

        .search-box {
            position: relative;
            flex: 1 1 240px;
            max-width: 360px;
        }

        .search-box i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
        }

        .search-box .form-control {
            padding-left: 42px;
            border-radius: 999px;
        }

        .toolbar .form-select {
            border-radius: 999px;
            width: auto;
            min-width: 160px;
        }

        .table-soft {
            margin: 0;
            min-width: 820px;
        }

        .table-soft thead th {
            background: #F8FAF9;
            color: var(--forest);
            font-size: 12.5px;
            font-weight: 800;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border);
            padding: 13px 16px;
            white-space: nowrap;
        }

        .table-soft tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-color: var(--border);
            font-size: 14.5px;
        }

        .table-soft tbody tr:hover {
            background: #FBFDFC;
        }

        .item-cell {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 220px;
        }

        .item-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--mint-soft);
            color: #2D9B6A;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .item-icon.gold {
            background: var(--gold-light);
            color: var(--peach-text);
        }

        .item-name {
            font-weight: 800;
            color: var(--forest);
            line-height: 1.25;
        }

        .item-sub {
            font-size: 12.5px;
            color: var(--muted);
        }

        .row-actions {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
        }

        .act-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: #EEF4F0;
            color: var(--forest);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            transition: background 0.15s ease, color 0.15s ease, transform 0.15s ease;
        }

        .act-btn:hover {
            background: var(--mint-soft);
            color: var(--forest);
            transform: translateY(-2px);
        }

        .act-btn.edit:hover {
            background: var(--gold-light);
            color: var(--peach-text);
        }

        .act-btn.del:hover {
            background: var(--pink-light);
            color: var(--pink-text);
        }

        .table-footer {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            justify-content: space-between;
            margin-top: 18px;
            color: var(--muted);
            font-size: 13.5px;
        }

        .pagination {
            margin: 0;
            gap: 6px;
        }

        .pagination .page-link {
            border: 1px solid var(--border);
            border-radius: 50% !important;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            color: var(--text);
            font-weight: 700;
            font-size: 13.5px;
        }

        .pagination .page-item.active .page-link {
            background: var(--forest);
            border-color: var(--forest);
            color: #fff;
        }

        .pagination .page-link:hover {
            background: var(--mint-soft);
        }

        .pagination .page-item.disabled .page-link {
            color: var(--muted);
            background: #F8FAF9;
        }

        .header-row {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: flex-start;
            justify-content: space-between;
        }

        @media (max-width: 576px) {
            .header-row .btn-primary-green {
                width: 100%;
            }

            .search-box {
                max-width: 100%;
                flex-basis: 100%;
            }

            .toolbar .form-select {
                flex: 1 1 calc(50% - 5px);
                min-width: 0;
            }

            .table-footer {
                justify-content: center;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="header-row">
        <div>
            <h1 class="page-heading">Kelola Potensi Desa</h1>
            <p class="page-sub">Tambah, ubah, dan hapus data potensi & UMKM yang ditampilkan kepada masyarakat.</p>
        </div>
        <button type="button" class="btn-primary-green" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg"></i> Tambah Potensi
        </button>
    </div>

    {{-- Notifikasi Sukses / Error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show my-3 rounded-4 border-0 shadow-sm" role="alert" style="background:#EBF7F0; color:#1C6544;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show my-3 rounded-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Ada kesalahan input:</strong>
            <ul class="mb-0 mt-1 small">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 mb-4 mt-1">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon forest"><i class="bi bi-stars"></i></div>
                <div>
                    <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                    <div class="stat-label">Total Potensi</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon mint"><i class="bi bi-flower1"></i></div>
                <div>
                    <div class="stat-value">{{ $stats['pertanian'] ?? 0 }}</div>
                    <div class="stat-label">Pertanian</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon gold"><i class="bi bi-shop"></i></div>
                <div>
                    <div class="stat-value">{{ $stats['umkm'] ?? 0 }}</div>
                    <div class="stat-label">UMKM</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon pink"><i class="bi bi-camera-fill"></i></div>
                <div>
                    <div class="stat-value">{{ $stats['wisata'] ?? 0 }}</div>
                    <div class="stat-label">Wisata</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="section-card">
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.potensi.index') }}" class="toolbar-filters w-100 d-flex flex-wrap align-items-center gap-2">
                <div class="search-box flex-grow-1">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" class="form-control" placeholder="Cari potensi / UMKM / pemilik..."
                        value="{{ request('search') }}" aria-label="Cari potensi desa">
                </div>
                <select name="status" class="form-select" onchange="this.form.submit()" aria-label="Filter status">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Draft" {{ request('status') === 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Nonaktif" {{ request('status') === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.potensi.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 text-decoration-none">
                        <i class="bi bi-x-circle me-1"></i> Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-soft align-middle">
                <thead>
                    <tr>
                        <th style="width:48px;">No</th>
                        <th>Nama UMKM / Potensi</th>
                        <th>Pemilik</th>
                        <th>Lokasi / Kontak</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($potensis as $index => $item)
                        <tr>
                            <td>{{ $potensis->firstItem() + $index }}</td>
                            <td>
                                <div class="item-name">{{ $item->nama }}</div>
                                <div class="item-sub">
                                    <span class="badge bg-light text-dark border">{{ $item->kategori ?? 'UMKM' }}</span>
                                    @if($item->harga_teks)
                                        <span class="ms-1 text-muted">{{ $item->harga_teks }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $item->pemilik ?? '-' }}</td>
                            <td>
                                <div>{{ $item->lokasi ?? '-' }}</div>
                                @if($item->kontak)
                                    <small class="text-muted"><i class="bi bi-telephone"></i> {{ $item->kontak }}</small>
                                @endif
                            </td>
                            <td>
                                @if($item->status === 'Aktif')
                                    <span class="pill pill-mint"><i class="bi bi-circle-fill" style="font-size:7px;"></i> Aktif</span>
                                @elseif($item->status === 'Draft')
                                    <span class="pill pill-gold"><i class="bi bi-circle-fill" style="font-size:7px;"></i> Draft</span>
                                @else
                                    <span class="pill pill-pink"><i class="bi bi-circle-fill" style="font-size:7px;"></i> Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="row-actions">
                                    <a href="{{ route('admin.potensi.show', $item->id) }}" class="act-btn" title="Lihat detail" aria-label="Lihat detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <button type="button" class="act-btn edit btn-edit-potensi" title="Ubah" aria-label="Ubah"
                                        data-bs-toggle="modal" data-bs-target="#modalUbah"
                                        data-action="{{ route('admin.potensi.update', $item->id) }}"
                                        data-nama="{{ $item->nama }}"
                                        data-kategori="{{ $item->kategori }}"
                                        data-status="{{ $item->status }}"
                                        data-lokasi="{{ $item->lokasi }}"
                                        data-pemilik="{{ $item->pemilik }}"
                                        data-kontak="{{ $item->kontak }}"
                                        data-harga="{{ $item->harga_teks }}"
                                        data-deskripsi="{{ $item->deskripsi }}">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button type="button" class="act-btn del btn-hapus-potensi" title="Hapus" aria-label="Hapus"
                                        data-bs-toggle="modal" data-bs-target="#modalHapus"
                                        data-action="{{ route('admin.potensi.destroy', $item->id) }}"
                                        data-nama="{{ $item->nama }}">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                Belum ada data potensi desa yang sesuai pencarian / filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Navigasi Paging Bawah --}}
        <div class="table-footer d-flex flex-wrap align-items-center justify-content-between mt-3">
            <div>
                Menampilkan {{ $potensis->firstItem() ?? 0 }}–{{ $potensis->lastItem() ?? 0 }} dari {{ $potensis->total() }} data
            </div>
            <div>
                {{ $potensis->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.potensi.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Potensi Desa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 field-group mb-3">
                                <label class="field-label">Nama UMKM / Potensi</label>
                                <input type="text" class="form-control" name="nama" placeholder="Contoh: Keripik Tempe Renyah" required>
                            </div>

                            <div class="col-md-4 field-group mb-3">
                                <label class="field-label">Kategori</label>
                                <select class="form-select" name="kategori" required>
                                    <option value="UMKM" selected>UMKM</option>
                                    <option value="Pertanian">Pertanian</option>
                                    <option value="Wisata">Wisata</option>
                                </select>
                            </div>

                            <div class="col-md-6 field-group mb-3">
                                <label class="field-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="Aktif" selected>Aktif</option>
                                    <option value="Draft">Draft</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                            <div class="col-md-6 field-group mb-3">
                                <label class="field-label">Harga (Opsional)</label>
                                <input type="text" class="form-control" name="harga_teks" placeholder="Contoh: Rp 15.000 - Rp 25.000">
                            </div>
                            <div class="col-md-6 field-group mb-3">
                                <label class="field-label">Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" placeholder="Dusun Krajan, Desa Jarak" required>
                            </div>
                            <div class="col-md-6 field-group mb-3">
                                <label class="field-label">Pemilik</label>
                                <input type="text" class="form-control" name="pemilik" placeholder="Nama pemilik / pengelola" required>
                            </div>
                            <div class="col-md-6 field-group mb-3">
                                <label class="field-label">Kontak / WhatsApp</label>
                                <input type="tel" class="form-control" name="kontak" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="col-md-6 field-group mb-3">
                                <label class="field-label">Foto Produk / Lokasi</label>
                                <input type="file" class="form-control" name="foto" accept="image/*">
                            </div>
                            <div class="col-12 field-group mb-0">
                                <label class="field-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3" placeholder="Jelaskan mengenai keunggulan produk / potensi ini..." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline-soft" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-primary-green">
                            <i class="bi bi-check2-circle"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Ubah --}}
    <div class="modal fade" id="modalUbah" tabindex="-1" aria-labelledby="modalUbahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <form id="formUbahPotensi" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUbahLabel">Ubah Potensi Desa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 field-group mb-3">
                                <label class="field-label">Nama UMKM / Potensi</label>
                                <input type="text" class="form-control" id="edit_nama" name="nama" required>
                            </div>

                            <div class="col-md-4 field-group mb-3">
                                <label class="field-label">Kategori</label>
                                <select class="form-select" id="edit_kategori" name="kategori" required>
                                    <option value="UMKM">UMKM</option>
                                    <option value="Pertanian">Pertanian</option>
                                    <option value="Wisata">Wisata</option>
                                </select>
                            </div>

                            <div class="col-md-6 field-group mb-3">
                                <label class="field-label">Status</label>
                                <select class="form-select" id="edit_status" name="status" required>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Draft">Draft</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                            <div class="col-md-6 field-group mb-3">
                                <label class="field-label">Harga (Opsional)</label>
                                <input type="text" class="form-control" id="edit_harga_teks" name="harga_teks">
                            </div>
                            <div class="col-md-6 field-group mb-3">
                                <label class="field-label">Lokasi</label>
                                <input type="text" class="form-control" id="edit_lokasi" name="lokasi" required>
                            </div>
                            <div class="col-md-6 field-group mb-3">
                                <label class="field-label">Pemilik</label>
                                <input type="text" class="form-control" id="edit_pemilik" name="pemilik" required>
                            </div>
                            <div class="col-md-6 field-group mb-3">
                                <label class="field-label">Kontak / WhatsApp</label>
                                <input type="tel" class="form-control" id="edit_kontak" name="kontak">
                            </div>
                            <div class="col-md-6 field-group mb-3">
                                <label class="field-label">Ganti Foto (Biarkan kosong jika tidak diubah)</label>
                                <input type="file" class="form-control" name="foto" accept="image/*">
                            </div>
                            <div class="col-12 field-group mb-0">
                                <label class="field-label">Deskripsi</label>
                                <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline-soft" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-primary-green">
                            <i class="bi bi-check2-circle"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Hapus --}}
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formHapusPotensi" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHapusLabel">Hapus Potensi Desa?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data potensi <strong id="hapus_potensi_nama"></strong>? Tindakan ini akan menghapus data secara permanen dari database.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline-soft" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-danger-soft">
                            <i class="bi bi-trash3-fill"></i> Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Event Handler untuk Tombol Edit
    const editButtons = document.querySelectorAll('.btn-edit-potensi');
    const formUbah = document.getElementById('formUbahPotensi');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const action = this.getAttribute('data-action');
            formUbah.action = action;

            document.getElementById('edit_nama').value = this.getAttribute('data-nama') || '';
            document.getElementById('edit_kategori').value = this.getAttribute('data-kategori') || 'UMKM';
            document.getElementById('edit_status').value = this.getAttribute('data-status') || 'Aktif';
            document.getElementById('edit_lokasi').value = this.getAttribute('data-lokasi') || '';
            document.getElementById('edit_pemilik').value = this.getAttribute('data-pemilik') || '';
            document.getElementById('edit_kontak').value = this.getAttribute('data-kontak') || '';
            document.getElementById('edit_harga_teks').value = this.getAttribute('data-harga') || '';
            document.getElementById('edit_deskripsi').value = this.getAttribute('data-deskripsi') || '';
        });
    });

    // Event Handler untuk Tombol Hapus
    const deleteButtons = document.querySelectorAll('.btn-hapus-potensi');
    const formHapus = document.getElementById('formHapusPotensi');
    const hapusNamaLabel = document.getElementById('hapus_potensi_nama');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const action = this.getAttribute('data-action');
            const nama = this.getAttribute('data-nama') || 'ini';
            
            formHapus.action = action;
            hapusNamaLabel.textContent = `"${nama}"`;
        });
    });
});
</script>
@endpush

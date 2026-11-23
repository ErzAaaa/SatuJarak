@extends('admin-layout')

@section('title', 'Detail Potensi: ' . ($potensi->nama ?? 'Potensi Desa'))
@section('topbar_title', 'ADMIN · DETAIL POTENSI DESA')
@section('active_menu', 'potensi')

@push('styles')
    <style>
        .summary-card {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--mint-soft) 0%, var(--mint-mid) 100%);
            border-radius: var(--radius-lg);
            padding: 28px 32px;
            margin-bottom: 24px;
        }

        .summary-card::after {
            content: "";
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(108, 199, 160, 0.35);
            right: -60px;
            top: -80px;
            pointer-events: none;
        }

        .summary-card>* {
            position: relative;
            z-index: 1;
        }

        .summary-code {
            font-size: 12.5px;
            font-weight: 800;
            color: #15533F;
            letter-spacing: 1.2px;
            margin-bottom: 6px;
        }

        .summary-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--forest);
            margin-bottom: 20px;
            line-height: 1.35;
        }

        .summary-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .action-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 24px;
        }

        .table-soft {
            margin: 0;
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

        .table-soft tbody td,
        .table-soft tbody th {
            padding: 14px 16px;
            vertical-align: middle;
            border-color: var(--border);
            font-size: 14.5px;
        }

        .table-soft tbody tr:hover {
            background: #FBFDFC;
        }

        /* tabel detail (key / value) */
        .table-detail th[scope="row"] {
            width: 220px;
            background: #F8FAF9;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
        }

        .table-detail td {
            font-weight: 500;
            word-break: break-word;
        }

        .photo-box {
            border-radius: var(--radius-md);
            border: 1.5px dashed var(--sage);
            background: #F8FAF9;
            min-height: 220px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--muted);
            font-size: 13.5px;
            text-align: center;
            padding: 20px;
        }

        .photo-box i {
            font-size: 38px;
            color: var(--gold);
        }

        .note-card {
            background: linear-gradient(135deg, #FDEBD3 0%, #FBE3C0 100%);
            border-radius: var(--radius-lg);
            padding: 22px 24px;
            margin-bottom: 28px;
        }

        .note-card .section-title {
            margin-bottom: 8px;
        }

        .note-card p {
            margin: 0;
            color: var(--text);
        }

        @media (max-width: 576px) {
            .summary-card {
                padding: 22px;
            }

            .summary-title {
                font-size: 18px;
            }

            .action-bar>* {
                flex: 1 1 100%;
            }

            .table-detail th[scope="row"] {
                width: 130px;
                white-space: normal;
            }

            .table-soft tbody td,
            .table-soft tbody th {
                padding: 12px;
                font-size: 14px;
            }

            .note-card {
                padding: 18px;
            }
        }
    </style>
@endpush

@section('content')
    <h1 class="page-heading">Detail Potensi Desa</h1>
    <p class="page-sub">Lihat rincian lengkap data potensi & UMKM desa yang tersimpan.</p>

    {{-- Notifikasi Sukses / Error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show my-3 rounded-4 border-0 shadow-sm" role="alert" style="background:#EBF7F0; color:#1C6544;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Ringkasan --}}
    <div class="summary-card">
        <div class="summary-code">PTS-{{ str_pad($potensi->id, 4, '0', STR_PAD_LEFT) }}</div>
        <div class="summary-title">{{ $potensi->nama }}</div>
        <div class="summary-meta">
            @if($potensi->status === 'Aktif')
                <div class="status-badge status-aktif"><span class="status-dot status-aktif"></span> Aktif</div>
            @elseif($potensi->status === 'Draft')
                <div class="status-badge status-draft"><span class="status-dot status-draft"></span> Draft</div>
            @else
                <div class="status-badge status-nonaktif"><span class="status-dot status-nonaktif"></span> Nonaktif</div>
            @endif
            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill">{{ ($potensi->jenis_produk === 'Kerajinan') ? 'Kerajinan' : ($potensi->jenis_produk ?: ($potensi->kategori ?? 'UMKM')) }}</span>
        </div>
    </div>

    {{-- Aksi --}}
    <div class="action-bar">
        <a href="{{ route('admin.potensi.index') }}" class="btn-outline-soft"><i class="bi bi-arrow-left"></i> Kembali</a>
        <button type="button" class="btn-gold" data-bs-toggle="modal" data-bs-target="#modalUbah">
            <i class="bi bi-pencil-square"></i> Ubah
        </button>
        <button type="button" class="btn-danger-soft" data-bs-toggle="modal" data-bs-target="#modalHapus">
            <i class="bi bi-trash3-fill"></i> Hapus
        </button>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-8">
            {{-- Tabel detail --}}
            <div class="section-card">
                <div class="section-title">Detail Informasi</div>
                <div class="table-responsive">
                    <table class="table table-soft table-detail align-middle mb-0">
                        <tbody>
                            <tr>
                                <th scope="row">Kode</th>
                                <td>PTS-{{ str_pad($potensi->id, 4, '0', STR_PAD_LEFT) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nama UMKM / Potensi</th>
                                <td class="fw-bold">{{ $potensi->nama }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Kategori</th>
                                <td>{{ ($potensi->jenis_produk === 'Kerajinan') ? 'Kerajinan' : ($potensi->jenis_produk ?: ($potensi->kategori ?? 'UMKM')) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Harga Produk</th>
                                <td>{{ $potensi->harga_teks ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Lokasi</th>
                                <td>{{ $potensi->lokasi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nama Pemilik</th>
                                <td>{{ $potensi->pemilik ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Kontak / WhatsApp</th>
                                <td>
                                    @if($potensi->kontak)
                                        <a href="https://wa.me/{{ $potensi->whatsapp ?? preg_replace('/[^0-9]/', '', $potensi->kontak) }}" target="_blank" class="text-decoration-none">
                                            <i class="bi bi-whatsapp text-success me-1"></i> {{ $potensi->kontak }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td>
                                    @if($potensi->status === 'Aktif')
                                        <span class="pill pill-mint"><i class="bi bi-circle-fill" style="font-size:7px;"></i> Aktif</span>
                                    @elseif($potensi->status === 'Draft')
                                        <span class="pill pill-gold"><i class="bi bi-circle-fill" style="font-size:7px;"></i> Draft</span>
                                    @else
                                        <span class="pill pill-pink"><i class="bi bi-circle-fill" style="font-size:7px;"></i> Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Deskripsi</th>
                                <td>{{ $potensi->deskripsi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Dibuat</th>
                                <td>{{ $potensi->created_at ? $potensi->created_at->format('d M Y · H:i') . ' WIB' : '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Diperbarui</th>
                                <td>{{ $potensi->updated_at ? $potensi->updated_at->format('d M Y · H:i') . ' WIB' : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            {{-- Foto --}}
            <div class="section-card">
                <div class="section-title">Foto Produk / Potensi</div>
                @if($potensi->foto)
                    @php
                        $fotoUrl = Str::startsWith($potensi->foto, ['http://', 'https://']) 
                            ? $potensi->foto 
                            : (Str::startsWith($potensi->foto, 'images/') 
                                ? asset($potensi->foto) 
                                : asset('storage/' . $potensi->foto));
                    @endphp
                    <div class="text-center p-2 bg-light rounded-3">
                        <img src="{{ $fotoUrl }}" alt="{{ $potensi->nama }}" class="img-fluid rounded-3 shadow-sm" style="max-height: 280px; object-fit: cover;">
                    </div>
                @else
                    <div class="photo-box">
                        <i class="bi bi-image-fill"></i>
                        <div>Belum ada foto yang diunggah</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Ubah --}}
    <div class="modal fade" id="modalUbah" tabindex="-1" aria-labelledby="modalUbahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <form method="POST" action="{{ route('admin.potensi.update', $potensi->id) }}" enctype="multipart/form-data" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUbahLabel">Ubah Data UMKM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px);">
                    <div class="row g-3">
                        <div class="col-md-7 field-group">
                            <label class="field-label">Nama Produk UMKM <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" value="{{ $potensi->nama }}" required>
                        </div>
                        <div class="col-md-5 field-group">
                            <label class="field-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" name="kategori" required>
                                <option value="Makanan" {{ ($potensi->jenis_produk !== 'Kerajinan') ? 'selected' : '' }}>Makanan</option>
                                <option value="Kerajinan" {{ ($potensi->jenis_produk === 'Kerajinan') ? 'selected' : '' }}>Kerajinan</option>
                            </select>
                        </div>
                        <div class="col-md-6 field-group">
                            <label class="field-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="Aktif" {{ $potensi->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Draft" {{ $potensi->status === 'Draft' ? 'selected' : '' }}>Draft</option>
                                <option value="Nonaktif" {{ $potensi->status === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-6 field-group">
                            <label class="field-label">Harga Produk (Opsional)</label>
                            <input type="text" class="form-control" name="harga_teks" value="{{ $potensi->harga_teks }}">
                        </div>
                        <div class="col-md-6 field-group">
                            <label class="field-label">Pemilik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pemilik" value="{{ $potensi->pemilik }}" required>
                        </div>
                        <div class="col-md-6 field-group">
                            <label class="field-label">Kontak / WhatsApp</label>
                            <input type="tel" class="form-control" name="kontak" value="{{ $potensi->kontak }}">
                        </div>
                        <div class="col-md-6 field-group">
                            <label class="field-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="lokasi" value="{{ $potensi->lokasi }}" required>
                        </div>
                        <div class="col-md-6 field-group">
                            <label class="field-label">Ganti Foto (Kosongkan jika tidak diubah)</label>
                            <input type="file" class="form-control" name="foto" accept="image/*">
                        </div>
                        <div class="col-12 field-group">
                            <label class="field-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="deskripsi" rows="2" required>{{ $potensi->deskripsi }}</textarea>
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

    {{-- Modal Hapus --}}
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.potensi.destroy', $potensi->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHapusLabel">Hapus Potensi Desa?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        Potensi <strong>"{{ $potensi->nama }}"</strong> beserta seluruh rincian datanya akan dihapus permanen dari database. Tindakan ini tidak dapat dibatalkan.
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

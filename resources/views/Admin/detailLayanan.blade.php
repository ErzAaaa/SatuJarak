@extends('Layouts.app')

@section('title', 'Detail Layanan: ' . ($layanan->nama_layanan ?? 'Layanan Desa'))
@section('topbar_title', 'ADMIN · DETAIL LAYANAN')
@section('active_menu', 'layanan')

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

        .action-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 24px;
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

        .info-list {
            margin: 0;
        }

        .info-row {
            display: flex;
            gap: 16px;
            padding: 13px 0;
            border-bottom: 1px solid var(--border);
        }

        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-row:first-child {
            padding-top: 0;
        }

        .info-key {
            width: 190px;
            flex-shrink: 0;
            font-size: 13px;
            font-weight: 700;
            color: var(--muted);
        }

        .info-val {
            flex: 1;
            min-width: 0;
            color: var(--text-main);
            font-weight: 500;
            word-break: break-word;
        }

        .check-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .check-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: #F8FAF9;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            font-weight: 500;
        }

        .check-list i {
            color: var(--mint);
            font-size: 18px;
            line-height: 1.4;
        }

        .timeline-card {
            background: linear-gradient(135deg, #FDEBD3 0%, #FBE3C0 100%);
            border-radius: var(--radius-lg);
            padding: 24px;
            margin-bottom: 28px;
        }

        .timeline-card .section-title {
            margin-bottom: 16px;
        }

        .timeline-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .timeline-step-item {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 16px 20px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            box-shadow: 0 2px 8px rgba(183, 121, 31, 0.10);
        }

        .step-number {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--forest);
            color: #fff;
            font-weight: 800;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .step-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .step-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--forest);
            line-height: 1.3;
        }

        .step-time {
            font-size: 14px;
            color: var(--muted);
            font-weight: 500;
        }

        /* table */
        .table-soft {
            margin: 0;
            min-width: 620px;
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

        @media (max-width: 576px) {
            .summary-card {
                padding: 22px;
            }

            .summary-title {
                font-size: 18px;
            }

            .timeline-card {
                padding: 16px;
            }

            .timeline-step-item {
                padding: 14px 16px;
                gap: 12px;
            }

            .step-title {
                font-size: 15px;
            }

            .step-time {
                font-size: 13px;
            }

            .info-row {
                flex-direction: column;
                gap: 2px;
            }

            .info-key {
                width: 100%;
            }

            .action-bar>* {
                flex: 1 1 100%;
            }
        }
    </style>
@endpush

@section('content')
    <h1 class="page-heading">Detail Layanan</h1>
    <p class="page-sub">Kelola informasi, tautan, dan data operasional layanan publik desa.</p>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; margin-bottom: 20px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; margin-bottom: 20px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Mohon periksa input:
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Ringkasan --}}
    <div class="summary-card">
        <div class="summary-code">{{ $layanan->kode_layanan ?: ('LYN-' . str_pad($layanan->id, 3, '0', STR_PAD_LEFT)) }}</div>
        <div class="summary-title">{{ $layanan->nama_layanan }}</div>
        <div class="status-badge {{ $layanan->status === 'Aktif' ? 'status-aktif' : 'status-nonaktif' }}">
            <span class="status-dot {{ $layanan->status === 'Aktif' ? 'status-aktif' : 'status-nonaktif' }}"></span> {{ $layanan->status }}
        </div>
    </div>

    {{-- Aksi --}}
    <div class="action-bar">
        <a href="{{ route('admin.layanan.index') }}" class="btn-outline-soft"><i class="bi bi-arrow-left"></i> Kembali</a>
        <button type="button" class="btn-gold" data-bs-toggle="modal" data-bs-target="#modalUbah"><i
                class="bi bi-pencil-square"></i> Ubah</button>
        @if($layanan->status === 'Aktif')
            <button type="button" class="btn-outline-soft" data-bs-toggle="modal" data-bs-target="#modalNonaktif"><i
                    class="bi bi-slash-circle"></i> Nonaktifkan</button>
        @else
            <button type="button" class="btn-gold" data-bs-toggle="modal" data-bs-target="#modalNonaktif"><i
                    class="bi bi-check-circle"></i> Aktifkan</button>
        @endif
        <button type="button" class="btn-danger-soft" data-bs-toggle="modal" data-bs-target="#modalHapus"><i
                class="bi bi-trash3-fill"></i> Hapus</button>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-7">
            {{-- Informasi Layanan --}}
            <div class="section-card">
                <div class="section-title">Informasi Layanan</div>
                <div class="info-list">
                    <div class="info-row">
                        <div class="info-key">ID Layanan</div>
                        <div class="info-val"><strong>{{ $layanan->kode_layanan ?: ('LYN-' . str_pad($layanan->id, 3, '0', STR_PAD_LEFT)) }}</strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-key">Nama Layanan</div>
                        <div class="info-val"><strong>{{ $layanan->nama_layanan }}</strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-key">Kategori</div>
                        <div class="info-val"><span class="pill pill-mint">{{ ucfirst($layanan->kategori ?? 'Umum') }}</span></div>
                    </div>
                    <div class="info-row">
                        <div class="info-key">Deskripsi</div>
                        <div class="info-val">{{ $layanan->deskripsi ?: 'Tidak ada deskripsi.' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-key">Link Layanan</div>
                        <div class="info-val">
                            @if(!empty($layanan->link_url) && $layanan->link_url !== '#')
                                <a href="{{ $layanan->link_url }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
                                    {{ $layanan->link_url }} <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 11px;"></i>
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-key">Status</div>
                        <div class="info-val">
                            <span class="badge {{ $layanan->status === 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $layanan->status }}
                            </span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-key">Dibuat</div>
                        <div class="info-val">{{ $layanan->created_at ? $layanan->created_at->translatedFormat('d M Y · H:i') . ' WIB' : '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-key">Diperbarui</div>
                        <div class="info-val">{{ $layanan->updated_at ? $layanan->updated_at->translatedFormat('d M Y · H:i') . ' WIB' : '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
            {{-- Foto / Icon --}}
            <div class="section-card">
                <div class="section-title">Icon / Logo Layanan</div>
                @if(!empty($layanan->logo))
                    <div class="p-3 text-center bg-white rounded-3 border d-flex flex-column align-items-center justify-content-center" style="min-height: 220px;">
                        <img src="{{ $layanan->logo_url }}" alt="{{ $layanan->nama_layanan }}" class="img-fluid rounded" style="max-height: 180px; max-width: 100%; object-fit: contain;">
                    </div>
                @else
                    <div class="photo-box">
                        <i class="bi bi-image-fill"></i>
                        <div>Belum ada icon/foto yang diunggah</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Pengajuan terbaru --}}
    <div class="section-card mt-4">
        <div class="section-title">Pengajuan Kerjasama / Riset Terkait</div>
        <div class="table-responsive">
            <table class="table table-soft align-middle">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pemohon</th>
                        <th>Judul Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuans as $p)
                        <tr>
                            <td><strong>PGJ-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                            <td>{{ $p->nama_lengkap ?? ($p->user->name ?? '-') }}</td>
                            <td>{{ Str::limit($p->judul_kerjasama ?? ($p->deskripsi ?? '-'), 50) }}</td>
                            <td>{{ $p->created_at ? $p->created_at->translatedFormat('d M Y') : '-' }}</td>
                            <td>
                                @if($p->status === 'Disetujui' || $p->status === 'Selesai')
                                    <span class="pill pill-mint">{{ $p->status }}</span>
                                @elseif($p->status === 'Ditolak')
                                    <span class="pill pill-pink">{{ $p->status }}</span>
                                @else
                                    <span class="pill pill-gold">{{ $p->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada pengajuan kegiatan terkait saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Ubah --}}
    <div class="modal fade" id="modalUbah" tabindex="-1" aria-labelledby="modalUbahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <form method="POST" action="{{ route('admin.layanan.update', $layanan->id) }}" enctype="multipart/form-data" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUbahLabel">Ubah Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px);">
                    <div class="row g-3">
                        <div class="col-md-6 field-group">
                            <label class="field-label">Kode / ID Layanan <span class="badge bg-light text-muted border ms-1">Terkunci</span></label>
                            <input type="text" class="form-control bg-light" name="kode_layanan"
                                value="{{ old('kode_layanan', $layanan->kode_layanan) }}" readonly>
                            <small class="text-muted">ID Layanan diatur berurutan secara otomatis.</small>
                        </div>
                        <div class="col-md-6 field-group">
                            <label class="field-label">Nama Layanan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_layanan"
                                value="{{ old('nama_layanan', $layanan->nama_layanan) }}" required>
                        </div>
                        <div class="col-md-6 field-group">
                            <label class="field-label">Kategori</label>
                            <select class="form-select" name="kategori">
                                <option value="masyarakat" {{ old('kategori', $layanan->kategori) === 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                                <option value="aparatur" {{ old('kategori', $layanan->kategori) === 'aparatur' ? 'selected' : '' }}>Aparatur Desa</option>
                                <option value="Administrasi Akademik" {{ old('kategori', $layanan->kategori) === 'Administrasi Akademik' ? 'selected' : '' }}>Administrasi Akademik</option>
                                <option value="Kependudukan" {{ old('kategori', $layanan->kategori) === 'Kependudukan' ? 'selected' : '' }}>Kependudukan</option>
                                <option value="Perizinan" {{ old('kategori', $layanan->kategori) === 'Perizinan' ? 'selected' : '' }}>Perizinan</option>
                                <option value="Sosial" {{ old('kategori', $layanan->kategori) === 'Sosial' ? 'selected' : '' }}>Sosial</option>
                            </select>
                        </div>
                        <div class="col-md-6 field-group">
                            <label class="field-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="Aktif" {{ old('status', $layanan->status) === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non Aktif" {{ old('status', $layanan->status) === 'Non Aktif' || old('status', $layanan->status) === 'Nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                                <option value="Draft" {{ old('status', $layanan->status) === 'Draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="col-12 field-group">
                            <label class="field-label">Link Layanan</label>
                            <input type="url" class="form-control" name="link_url" value="{{ old('link_url', $layanan->link_url) }}" placeholder="https://...">
                        </div>
                        <div class="col-12 field-group">
                            <label class="field-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="2">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                        </div>
                        <div class="col-12 field-group">
                            <label class="field-label">Ganti Foto / Icon (Opsional)</label>
                            <input type="file" class="form-control" name="logo" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah icon.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline-soft" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-green"><i class="bi bi-check2-circle"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Nonaktifkan / Aktifkan --}}
    <div class="modal fade" id="modalNonaktif" tabindex="-1" aria-labelledby="modalNonaktifLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.layanan.toggleStatus', $layanan->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNonaktifLabel">
                            {{ $layanan->status === 'Aktif' ? 'Nonaktifkan Layanan?' : 'Aktifkan Layanan?' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        @if($layanan->status === 'Aktif')
                            Layanan <strong>{{ $layanan->nama_layanan }}</strong> tidak akan tampil di halaman publik sampai diaktifkan kembali. Data layanan tetap tersimpan di sistem.
                        @else
                            Layanan <strong>{{ $layanan->nama_layanan }}</strong> akan kembali aktif dan dapat diakses oleh masyarakat di halaman publik.
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline-soft" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="{{ $layanan->status === 'Aktif' ? 'btn-gold' : 'btn-primary-green' }}">
                            <i class="bi {{ $layanan->status === 'Aktif' ? 'bi-slash-circle' : 'bi-check-circle' }}"></i>
                            Ya, {{ $layanan->status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
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
                <form method="POST" action="{{ route('admin.layanan.destroy', $layanan->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHapusLabel">Hapus Layanan?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        Layanan <strong>{{ $layanan->nama_layanan }}</strong> akan dihapus permanen dari sistem. Tindakan ini tidak dapat dibatalkan.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline-soft" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-danger-soft"><i class="bi bi-trash3-fill"></i> Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

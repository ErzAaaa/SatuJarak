<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satu Jarak - Detail Pengajuan</title>
    <!-- Favicon / Logo Satu Jarak -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin/detailPengajuan.css') }}">
</head>

<body>

<div class="admin-layout">

    <!-- Sidebar -->
    <aside class="sidebar">

        <!-- Mobile Close Button -->
        <button class="sidebar-close" id="sidebarCloseBtn">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="sidebar-brand">

            <div class="logo-mark">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Satu Jarak">
            </div>

            <h2>Satu Jarak</h2>
            <span>Pelayanan Publik Desa</span>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.pengajuan.index') }}" class="nav-item active">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>Pengajuan</span>
                <i class="bi bi-chevron-right nav-arrow"></i>
            </a>

            <a href="{{ route('admin.layanan.index') }}" class="nav-item">
                <i class="bi bi-briefcase-fill"></i>
                <span>Layanan</span>
            </a>

            <a href="{{ route('admin.potensi.index') }}" class="nav-item">
                <i class="bi bi-building-fill"></i>
                <span>Potensi Desa</span>
            </a>

            {{-- Fitur kelola pengguna dinonaktifkan sementara --}}
            {{-- <a href="{{ route('admin.users.index') }}" class="nav-item">
                <i class="bi bi-people-fill"></i>
                <span>User</span>
            </a> --}}
        </nav>

        <!-- Logout -->
        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}" class="w-100">
                @csrf
                <button type="submit" class="logout-btn border-0 w-100" style="cursor: pointer;">
                    <span>Log Out</span>
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <!-- Header -->
        <header class="top-header">

            <div class="mobile-menu">
                <button class="btn" id="mobileMenuBtn">
                    <i class="bi bi-list" id="menuIcon"></i>
                </button>
            </div>
        </header>

        <!-- Content -->
        <section class="content">

            <!-- Page Heading -->
            <div class="page-heading animate-item">
                <div>
                    <span class="heading-label">ADMINISTRASI DESA</span>
                    <h1>Detail Pengajuan</h1>
                    <p>Informasi lengkap dan pengelolaan pengajuan masyarakat Desa Jarak</p>
                </div>

                <a href="{{ route('admin.pengajuan.index') }}" class="back-button">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-4 animate-item" style="border-radius: 12px; font-size: 14px;">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @php
                $kode = 'PGJ-' . str_pad($pengajuan->id, 3, '0', STR_PAD_LEFT);
                $statusClass = match($pengajuan->status) {
                    'Menunggu Verifikasi' => 'waiting',
                    'Sedang Diproses' => 'process',
                    'Selesai' => 'completed',
                    'Ditolak' => 'rejected',
                    default => 'waiting',
                };
                $statusIcon = match($pengajuan->status) {
                    'Menunggu Verifikasi' => 'bi-clock-fill',
                    'Sedang Diproses' => 'bi-arrow-repeat',
                    'Selesai' => 'bi-check-circle-fill',
                    'Ditolak' => 'bi-x-circle-fill',
                    default => 'bi-clock-fill',
                };
            @endphp

            <!-- Status -->
            <div class="detail-status-card animate-item">

                <div class="status-left">
                    <div class="status-icon">
                        <i class="bi bi-file-earmark-check-fill"></i>
                    </div>

                    <div>
                        <span class="small-label">ID PENGAJUAN</span>
                        <h3 id="applicationId">{{ $kode }}</h3>
                    </div>
                </div>

                <div class="status-right">
                    <span class="status-label">Status Saat Ini</span>

                    <span class="status-badge {{ $statusClass }}" id="applicationStatus">
                        <i class="bi {{ $statusIcon }}"></i>
                        {{ $pengajuan->status }}
                    </span>
                </div>
            </div>

            @if ($pengajuan->catatan_admin)
                <div class="alert {{ $pengajuan->status === 'Ditolak' ? 'alert-danger' : 'alert-warning' }} d-flex align-items-start gap-2 mb-4 animate-item" style="border-radius: 12px; font-size: 14px;">
                    <i class="bi bi-info-circle-fill fs-5 mt-1"></i>
                    <div>
                        <strong>Catatan Admin Saat Ini:</strong>
                        <div>{{ $pengajuan->catatan_admin }}</div>
                    </div>
                </div>
            @endif

            <!-- Detail Grid -->
            <div class="detail-grid">

                <!-- Detail Main -->
                <div class="detail-main">

                    <!-- Data Pemohon -->
                    <div class="detail-card animate-item">
                        <div class="card-heading">
                            <div class="heading-icon">
                                <i class="bi bi-person-fill"></i>
                            </div>

                            <div>
                                <h3>Data Pemohon</h3>
                                <p>Informasi identitas pemohon</p>
                            </div>
                        </div>

                        <div class="info-grid">
                            <div class="info-item">
                                <span>Nama Lengkap</span>
                                <strong id="applicantName">{{ $pengajuan->nama_lengkap ?? ($pengajuan->user->name ?? '-') }}</strong>
                            </div>

                            <div class="info-item">
                                <span>Email</span>
                                <strong id="applicantEmail">{{ $pengajuan->email_pemohon ?? ($pengajuan->user->email ?? '-') }}</strong>
                            </div>

                            <div class="info-item">
                                <span>No. Telepon / WhatsApp</span>
                                <strong id="applicantPhone">{{ $pengajuan->no_hp ?? '-' }}</strong>
                            </div>

                            <div class="info-item">
                                <span>Instansi / Universitas</span>
                                <strong id="institution">{{ $pengajuan->nama_instansi ?? ($pengajuan->universitas ?? '-') }}</strong>
                            </div>

                            @if($pengajuan->nim)
                            <div class="info-item">
                                <span>NIM / No. Identitas</span>
                                <strong>{{ $pengajuan->nim }}</strong>
                            </div>
                            @endif

                            @if($pengajuan->program_studi || $pengajuan->fakultas)
                            <div class="info-item">
                                <span>Program Studi / Fakultas</span>
                                <strong>{{ $pengajuan->program_studi ?? '-' }} {{ $pengajuan->fakultas ? '(' . $pengajuan->fakultas . ')' : '' }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Detail Pengajuan -->
                    <div class="detail-card animate-item">
                        <div class="card-heading">
                            <div class="heading-icon gold">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </div>

                            <div>
                                <h3>Detail Pengajuan</h3>
                                <p>Informasi pengajuan yang diajukan</p>
                            </div>
                        </div>

                        <div class="info-grid">
                            <div class="info-item full">
                                <span>Judul Pengajuan / Kerjasama</span>
                                <strong id="applicationTitle">{{ $pengajuan->judul_kerjasama ?? $pengajuan->judul_kegiatan ?? '-' }}</strong>
                            </div>

                            <div class="info-item">
                                <span>Jenis Kegiatan</span>
                                <strong id="applicationService">{{ $pengajuan->jenis_kegiatan ?? 'KKN / Riset' }}</strong>
                            </div>

                            <div class="info-item">
                                <span>Tanggal Diajukan</span>
                                <strong id="applicationDate">{{ $pengajuan->created_at ? $pengajuan->created_at->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}</strong>
                            </div>

                            <div class="info-item">
                                <span>Lokasi Kegiatan</span>
                                <strong>{{ $pengajuan->lokasi ?? 'Desa Jarak' }}</strong>
                            </div>

                            <div class="info-item">
                                <span>Periode Kegiatan</span>
                                <strong>
                                    {{ $pengajuan->tanggal_mulai ? $pengajuan->tanggal_mulai->format('d/m/Y') : '-' }}
                                    @if ($pengajuan->tanggal_selesai)
                                        s.d. {{ $pengajuan->tanggal_selesai->format('d/m/Y') }}
                                    @endif
                                </strong>
                            </div>

                            @if ($pengajuan->jumlah_peserta)
                            <div class="info-item">
                                <span>Jumlah Peserta</span>
                                <strong>{{ $pengajuan->jumlah_peserta }} Orang</strong>
                            </div>
                            @endif

                            @if ($pengajuan->dosen_pembimbing)
                            <div class="info-item">
                                <span>Dosen Pembimbing</span>
                                <strong>{{ $pengajuan->dosen_pembimbing }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Dokumen -->
                    <div class="detail-card animate-item">
                        <div class="card-heading">
                            <div class="heading-icon green">
                                <i class="bi bi-folder-fill"></i>
                            </div>

                            <div>
                                <h3>Dokumen Persyaratan</h3>
                                <p>Dokumen yang dilampirkan oleh pemohon</p>
                            </div>
                        </div>

                        <div class="document-list">
                            @if ($pengajuan->file_proposal)
                                <div class="document-item">
                                    <div class="document-icon">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </div>
                                    <div class="document-info">
                                        <strong>Proposal Kegiatan</strong>
                                        <span>PDF Terlampir</span>
                                    </div>
                                    <a href="{{ asset('storage/' . $pengajuan->file_proposal) }}" target="_blank" class="document-btn text-decoration-none">
                                        <i class="bi bi-eye"></i> Lihat PDF
                                    </a>
                                </div>
                            @endif

                            @if ($pengajuan->file_surat)
                                <div class="document-item">
                                    <div class="document-icon">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </div>
                                    <div class="document-info">
                                        <strong>Surat Pengantar Instansi</strong>
                                        <span>PDF Terlampir</span>
                                    </div>
                                    <a href="{{ asset('storage/' . $pengajuan->file_surat) }}" target="_blank" class="document-btn text-decoration-none">
                                        <i class="bi bi-eye"></i> Lihat PDF
                                    </a>
                                </div>
                            @endif

                            @if (!$pengajuan->file_proposal && !$pengajuan->file_surat)
                                <p class="text-muted mb-0">Tidak ada berkas PDF yang dilampirkan.</p>
                            @endif
                        </div>
                    </div>

                    @if ($pengajuan->deskripsi)
                    <!-- Catatan Pemohon -->
                    <div class="detail-card animate-item">
                        <div class="card-heading">
                            <div class="heading-icon gold">
                                <i class="bi bi-chat-left-text-fill"></i>
                            </div>

                            <div>
                                <h3>Keterangan Tambahan Pemohon</h3>
                                <p>Deskripsi yang disampaikan pemohon</p>
                            </div>
                        </div>

                        <div class="applicant-note">
                            {{ $pengajuan->deskripsi }}
                        </div>
                    </div>
                    @endif

                    <!-- Aksi Pengajuan -->
                    <div class="detail-card action-card animate-item">
                        <div class="card-heading">
                            <div class="heading-icon action">
                                <i class="bi bi-lightning-charge-fill"></i>
                            </div>

                            <div>
                                <h3>Aksi Pengajuan</h3>
                                <p>Pilih tindakan yang ingin dilakukan terhadap pengajuan ini</p>
                            </div>
                        </div>

                        <div class="action-buttons">

                            <!-- Tombol Perlu Perbaikan -->
                            <button type="button" class="action-btn repair-btn" data-bs-toggle="modal" data-bs-target="#repairModal">
                                <div class="action-btn-icon">
                                    <i class="bi bi-pencil-square"></i>
                                </div>

                                <div class="action-btn-text">
                                    <strong>Perlu Perbaikan</strong>
                                    <span>Minta pemohon memperbaiki data</span>
                                </div>

                                <i class="bi bi-arrow-right action-arrow"></i>
                            </button>

                            <!-- Tombol Tolak -->
                            <button type="button" class="action-btn reject-btn" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <div class="action-btn-icon">
                                    <i class="bi bi-x-circle-fill"></i>
                                </div>

                                <div class="action-btn-text">
                                    <strong>Tolak Pengajuan</strong>
                                    <span>Tolak pengajuan dari pemohon</span>
                                </div>

                                <i class="bi bi-arrow-right action-arrow"></i>
                            </button>

                           <!-- Tombol Verifikasi -->
<button type="button" class="action-btn verify-btn"
        data-bs-toggle="modal"
        data-bs-target="#verifyModal">
    <div class="action-btn-icon">
        <i class="bi bi-check-circle-fill"></i>
    </div>

    <div class="action-btn-text">
        <strong>Verifikasi</strong>
        <span>Setujui dan proses pengajuan</span>
    </div>

    <i class="bi bi-arrow-right action-arrow"></i>
</button>

<!-- Tombol Cetak Surat Persetujuan -->
@if($pengajuan->status === 'Selesai')
    <a href="{{ route('admin.pengajuan.surat', $pengajuan->id) }}"
       class="action-btn verify-btn"
       target="_blank">
        <div class="action-btn-icon">
            <i class="bi bi-file-earmark-check-fill"></i>
        </div>

        <div class="action-btn-text">
            <strong>Cetak Surat Persetujuan</strong>
            <span>Buka dan cetak surat persetujuan</span>
        </div>

        <i class="bi bi-arrow-right action-arrow"></i>
    </a>
@endif

                        </div>
                    </div>

                </div>
            </div>

        </section>
    </main>
</div>


<!-- =========================================================
     MODAL PERLU PERBAIKAN
========================================================= -->
<div class="modal fade" id="repairModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.pengajuan.update', $pengajuan->id) }}" class="modal-content action-modal repair-modal">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="Sedang Diproses">

            <!-- Header -->
            <div class="modal-header">
                <div class="modal-top">
                    <div class="modal-action-icon repair">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <span class="modal-label repair">
                        Perbaikan
                    </span>
                </div>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <h5 class="modal-title">
                    Minta Perbaikan Data / Berkas
                </h5>
                <p class="modal-description">
                    Status akan diubah ke 'Sedang Diproses' dan pemohon akan menerima instruksi catatan Anda di akunnya.
                </p>
                <div class="modal-form-group text-start">
                    <label class="form-label fw-bold mb-1" style="font-size: 13px;">Catatan Perbaikan untuk Pemohon:</label>
                    <textarea
                        name="catatan_admin"
                        rows="4"
                        class="form-control"
                        placeholder="Contoh: Lampiran proposal belum memiliki tanda tangan dosen pembimbing, mohon diupload ulang."
                        required
                    >{{ old('catatan_admin', $pengajuan->catatan_admin) }}</textarea>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="modal-cancel-btn" data-bs-dismiss="modal">
                    Batal
                </button>
                <button
                    type="submit"
                    class="modal-submit-btn repair"
                >
                    Kirim Catatan
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </form>
    </div>
</div>


<!-- =========================================================
     MODAL TOLAK PENGAJUAN
========================================================= -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.pengajuan.update', $pengajuan->id) }}" class="modal-content action-modal reject-modal">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="Ditolak">

            <!-- Header -->
            <div class="modal-header">
                <div class="modal-top">
                    <div class="modal-action-icon reject">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <span class="modal-label reject">
                        Penolakan
                    </span>
                </div>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <h5 class="modal-title">
                    Tolak Pengajuan Permohonan
                </h5>
                <p class="modal-description">
                    Tolak pengajuan apabila tidak memenuhi persyaratan atau kuota kegiatan penuh.
                </p>
                <div class="modal-form-group text-start">
                    <label class="form-label fw-bold text-danger mb-1" style="font-size: 13px;">Alasan Penolakan (Wajib):</label>
                    <textarea
                        name="catatan_admin"
                        rows="4"
                        class="form-control"
                        placeholder="Berikan alasan penolakan secara jelas agar dapat dipahami oleh pemohon."
                        required
                    >{{ old('catatan_admin', $pengajuan->catatan_admin) }}</textarea>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="modal-cancel-btn" data-bs-dismiss="modal">
                    Batal
                </button>
                <button
                    type="submit"
                    class="modal-submit-btn reject"
                >
                    Tolak Pengajuan
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>


<!-- =========================================================
     MODAL VERIFIKASI / SETUJUI
========================================================= -->
<div class="modal fade" id="verifyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.pengajuan.update', $pengajuan->id) }}" class="modal-content action-modal verify-modal">
            @csrf
            @method('PATCH')

            <!-- Header -->
            <div class="modal-header">
                <div class="modal-top">
                    <div class="modal-action-icon verify">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <span class="modal-label verify">
                        Verifikasi
                    </span>
                </div>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <h5 class="modal-title">
                    Verifikasi & Setujui Pengajuan
                </h5>
                <p class="modal-description">
                    Pilih status persetujuan untuk pengajuan #{{ $kode }} dari {{ $pengajuan->nama_lengkap }}.
                </p>

                <div class="mb-3 text-start">
                    <label class="form-label fw-bold mb-1" style="font-size: 13px;">Pilih Status:</label>
                    <select name="status" class="form-select" required>
                        <option value="Selesai" {{ $pengajuan->status === 'Selesai' ? 'selected' : '' }}>Selesai / Setujui (Pemohon dapat mencetak Surat Persetujuan)</option>
                        <option value="Sedang Diproses" {{ $pengajuan->status === 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses (Tahapan verifikasi lanjutan)</option>
                    </select>
                </div>

                <div class="modal-form-group text-start">
                    <label class="form-label fw-bold mb-1" style="font-size: 13px;">Catatan Admin untuk Pemohon (Opsional):</label>
                    <textarea
                        name="catatan_admin"
                        rows="3"
                        class="form-control"
                        placeholder="Contoh: Berkas telah disetujui. Surat keterangan persetujuan dapat dicetak di sistem."
                    >{{ old('catatan_admin', $pengajuan->catatan_admin) }}</textarea>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="modal-cancel-btn" data-bs-dismiss="modal">
                    Batal
                </button>
                <button
                    type="submit"
                    class="modal-submit-btn verify"
                >
                    Simpan & Verifikasi
                    <i class="bi bi-check-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/admin/detailPengajuan.js') }}"></script>

</body>
</html>
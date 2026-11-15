<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengguna — {{ $user->name }} — Admin SatuJarak</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/admin/admin_detail_user.css') }}">

    <style>
        .online-dot {
            width: 10px;
            height: 10px;
            background-color: #10B981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
            animation: pulse-green 2s infinite;
        }
        @keyframes pulse-green {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
        .btn-action-custom {
            padding: 8px 18px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 13.5px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }
        .btn-action-edit {
            background-color: #F1F5F9;
            color: #334155;
        }
        .btn-action-edit:hover {
            background-color: #E2E8F0;
            color: #0F172A;
        }
        .btn-action-del {
            background-color: #FEE2E2;
            color: #DC2626;
        }
        .btn-action-del:hover {
            background-color: #FCA5A5;
            color: #991B1B;
        }
        .table-pengajuan th {
            font-size: 13px;
            color: #64748B;
            font-weight: 600;
            background: #F8FAFC;
        }
    </style>
</head>
<body>

<div class="detail-container">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- HEADER -->
    <div class="page-header d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.users.index') }}" class="btn-back text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Kelola Pengguna
        </a>
        <div class="page-title fw-bold">Detail Pengguna</div>
        <div style="width: 70px;"></div>
    </div>

    <!-- BANNER & KARTU PROFIL -->
    <div class="profile-banner"></div>
    <div class="profile-card">
        <div class="profile-main-info d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar" id="userAvatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="user-heading">
                    <h2 id="userName" class="mb-1">{{ $user->name }}</h2>
                    <p id="userUsername" class="text-muted mb-2">{{ $user->email }}</p>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        @if($user->role === 'Admin' || $user->is_admin)
                            <span class="badge bg-indigo-subtle text-primary border px-2 py-1 rounded-pill" style="font-size: 12px;">
                                <i class="bi bi-shield-fill me-1"></i> Administrator
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary border px-2 py-1 rounded-pill" style="font-size: 12px;">
                                <i class="bi bi-person me-1"></i> Pemohon / User
                            </span>
                        @endif

                        @if($user->status === 'Nonaktif')
                            <span class="badge bg-danger-subtle text-danger border px-2 py-1 rounded-pill" style="font-size: 12px;">
                                Nonaktif
                            </span>
                        @else
                            <span class="badge bg-success-subtle text-success border px-2 py-1 rounded-pill" style="font-size: 12px;">
                                Akun Aktif
                            </span>
                        @endif

                        @if($isOnline)
                            <span class="badge bg-success text-white px-2 py-1 rounded-pill" style="font-size: 12px;">
                                <span class="online-dot me-1"></span> Sedang Online
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="action-header-btns d-flex gap-2">
                <button type="button" class="btn-action-custom btn-action-edit" data-bs-toggle="modal" data-bs-target="#editUserModal">
                    <i class="bi bi-pencil-square"></i> Edit Pengguna
                </button>
                @if(auth()->id() !== $user->id)
                    <button type="button" class="btn-action-custom btn-action-del" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- MAIN BODY -->
    <div class="detail-body mt-4">
        <!-- INFORMASI AKUN -->
        <div class="mb-4">
            <div class="section-title fw-bold mb-3">Informasi Akun Pengguna</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Alamat Email</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">No. Telepon / WhatsApp</span>
                    <span class="info-value">{{ $user->no_hp ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Bergabung</span>
                    <span class="info-value">{{ $user->created_at ? $user->created_at->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status Sesi Login</span>
                    <span class="info-value">
                        @if($isOnline)
                            <span class="text-success fw-bold"><span class="online-dot me-1"></span> Online Sekarang</span>
                        @elseif($latestSession && $latestSession->last_activity)
                            {{ \Carbon\Carbon::createFromTimestamp($latestSession->last_activity)->diffForHumans() }}
                        @else
                            Belum pernah login
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">IP Address Terakhir</span>
                    <span class="info-value">{{ $latestSession->ip_address ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Perangkat / Browser</span>
                    <span class="info-value text-truncate" style="max-width: 250px;" title="{{ $latestSession->user_agent ?? '-' }}">
                        {{ $latestSession->user_agent ?? '-' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- RIWAYAT PENGAJUAN PERMOHONAN USER INI -->
        <div class="mb-4">
            <div class="section-title fw-bold mb-3 d-flex justify-content-between align-items-center">
                <span>Pengajuan Permohonan oleh User Ini</span>
                <span class="badge bg-light text-dark border">{{ $user->pengajuans->count() }} Permohonan</span>
            </div>
            <div class="table-responsive bg-white rounded-3 shadow-sm border">
                <table class="table table-pengajuan align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID Tiket</th>
                            <th>Judul / Layanan</th>
                            <th>Instansi</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->pengajuans as $item)
                            @php
                                $kode = 'PGJ-' . str_pad($item->id, 3, '0', STR_PAD_LEFT);
                                $badgeColor = match($item->status) {
                                    'Menunggu Verifikasi' => 'warning',
                                    'Sedang Diproses' => 'info',
                                    'Selesai' => 'success',
                                    'Ditolak' => 'danger',
                                    default => 'secondary',
                                };
                            @endphp
                            <tr>
                                <td><strong>#{{ $kode }}</strong></td>
                                <td>
                                    <div class="fw-bold">{{ $item->judul_kerjasama ?? $item->jenis_kegiatan ?? '-' }}</div>
                                    <small class="text-muted">{{ $item->program_studi ?? $item->fakultas ?? '' }}</small>
                                </td>
                                <td>{{ $item->nama_instansi ?? $item->universitas ?? '-' }}</td>
                                <td>{{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }} border border-{{ $badgeColor }}-subtle px-2 py-1 rounded-pill">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.pengajuan.show', $item->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                        Buka Detail <i class="bi bi-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                    User ini belum pernah membuat pengajuan permohonan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RIWAYAT AKTIVITAS SESI LOGIN -->
        <div>
            <div class="section-title fw-bold mb-3">Riwayat Sesi Login (Sessions)</div>
            <div class="table-responsive bg-white rounded-3 shadow-sm border">
                <table class="activity-table table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Sesi ID</th>
                            <th>IP Address</th>
                            <th>Perangkat / User Agent</th>
                            <th>Waktu Terakhir Aktif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions as $s)
                            <tr>
                                <td><code style="font-size: 12px;">{{ substr($s->id, 0, 12) }}...</code></td>
                                <td><strong>{{ $s->ip_address ?? '127.0.0.1' }}</strong></td>
                                <td style="font-size: 12.5px; max-width: 320px;" class="text-truncate" title="{{ $s->user_agent }}">
                                    {{ $s->user_agent ?? 'Unknown Browser' }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::createFromTimestamp($s->last_activity)->translatedFormat('d M Y, H:i') }} WIB
                                    <small class="text-muted d-block">({{ \Carbon\Carbon::createFromTimestamp($s->last_activity)->diffForHumans() }})</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">Belum ada riwayat sesi login tersimpan di sistem</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- MODAL EDIT USER -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="modal-content border-0 shadow" style="border-radius: 20px;">
            @csrf
            @method('PATCH')
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Data Akun Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">No. Handphone</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ $user->no_hp }}" placeholder="08xxxxxxxxxx">
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold" style="font-size: 13px;">Role Akses</label>
                        <select name="role" class="form-select" required>
                            <option value="User" {{ $user->role === 'User' ? 'selected' : '' }}>User (Pemohon)</option>
                            <option value="Admin" {{ ($user->role === 'Admin' || $user->is_admin) ? 'selected' : '' }}>Admin (Pengelola)</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold" style="font-size: 13px;">Status Akun</label>
                        <select name="status" class="form-select" required>
                            <option value="Aktif" {{ $user->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ $user->status === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Password Baru <small class="text-muted fw-normal">(Kosongkan jika tidak diubah)</small></label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 999px;">Batal</button>
                <button type="submit" class="btn btn-success fw-bold" style="border-radius: 999px;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS USER -->
@if(auth()->id() !== $user->id)
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="modal-content border-0 shadow text-center p-3" style="border-radius: 20px;">
            @csrf
            @method('DELETE')
            <div class="modal-body">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; border-radius: 50%; background: #FEE2E2; color: #DC2626; font-size: 26px;">
                    <i class="bi bi-trash-fill"></i>
                </div>
                <h5 class="fw-bold mb-2">Hapus Akun Pengguna?</h5>
                <p class="text-muted mb-4" style="font-size: 14px;">
                    Akun <strong>{{ $user->name }}</strong> ({{ $user->email }}) akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 999px;">Batal</button>
                    <button type="submit" class="btn btn-danger px-4 fw-bold" style="border-radius: 999px;">Ya, Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

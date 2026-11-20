<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna — Admin SatuJarak</title>
    <!-- Favicon / Logo Satu Jarak -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/managePengajuan.css') }}">

    <style>
        .online-dot {
            width: 9px;
            height: 9px;
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
        .user-avatar-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--mint), var(--forest));
            color: #ffffff;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }
        .role-badge-admin {
            background-color: #E0E7FF;
            color: #3730A3;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
        }
        .role-badge-user {
            background-color: #F1F5F9;
            color: #475569;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
        }
        .status-badge-active {
            background-color: #D1FAE5;
            color: #065F46;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
        }
        .status-badge-inactive {
            background-color: #FEE2E2;
            color: #991B1B;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
        }
        .btn-add-user {
            background: var(--forest);
            color: #ffffff;
            border: none;
            border-radius: 999px;
            padding: 10px 22px;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
        }
        .btn-add-user:hover {
            background: var(--forest-light);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(11, 56, 40, 0.25);
        }
    </style>
</head>
<body>

<div class="admin-layout">

    <!-- Sidebar -->
    <aside class="sidebar">
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

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.pengajuan.index') }}" class="nav-item">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>Pengajuan</span>
            </a>
            <a href="{{ route('admin.layanan.index') }}" class="nav-item">
                <i class="bi bi-briefcase-fill"></i>
                <span>Layanan</span>
            </a>
            <a href="{{ route('admin.potensi.index') }}" class="nav-item">
                <i class="bi bi-building-fill"></i>
                <span>Potensi Desa</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-item active">
                <i class="bi bi-people-fill"></i>
                <span>Kelola Pengguna</span>
                <i class="bi bi-chevron-right nav-arrow"></i>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}" class="w-100">
                @csrf
                <button type="submit" class="logout-btn border-0 bg-transparent w-100 text-start d-flex align-items-center justify-content-between text-white" style="cursor: pointer; padding: 10px 14px;">
                    <span>Log Out</span>
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <!-- Top Header -->
        <header class="top-header">
            <div class="mobile-menu">
                <button class="btn" id="mobileMenuBtn">
                    <i class="bi bi-list" id="menuIcon"></i>
                </button>
            </div>

            <div class="header-right ms-auto">
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-sm-block">
                        <strong class="d-block" style="font-size: 14px; color: var(--forest);">{{ auth()->user()->name ?? 'Administrator' }}</strong>
                        <span class="text-muted" style="font-size: 12px;">Admin SatuJarak</span>
                    </div>
                    <div class="user-avatar-circle" style="width: 42px; height: 42px;">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Body -->
        <section class="page-body">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 12px;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 12px;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 12px;">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Page Title -->
            <div class="page-intro animate-item d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <div class="breadcrumb-tag">ADMINISTRASI SISTEM</div>
                    <h1>Kelola Pengguna</h1>
                    <p>Pantau status login real-time, akun terdaftar, dan kelola hak akses pengguna</p>
                </div>
                <div>
                    <button type="button" class="btn-add-user" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="bi bi-person-plus-fill"></i> Tambah User Baru
                    </button>
                </div>
            </div>

            <!-- Statistic Cards -->
            <div class="row g-3 statistic-row">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card stat-total animate-item">
                        <div class="stat-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <span>Total Pengguna</span>
                            <h3>{{ $stats['total'] }}</h3>
                        </div>
                        <i class="bi bi-people-fill card-decoration"></i>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card stat-complete animate-item">
                        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">
                            <i class="bi bi-broadcast"></i>
                        </div>
                        <div>
                            <span>Sedang Online</span>
                            <h3>{{ $stats['online'] }}</h3>
                        </div>
                        <i class="bi bi-wifi card-decoration"></i>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card stat-process animate-item">
                        <div class="stat-icon">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <div>
                            <span>Administrator</span>
                            <h3>{{ $stats['admin'] }}</h3>
                        </div>
                        <i class="bi bi-shield-check card-decoration"></i>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card stat-waiting animate-item">
                        <div class="stat-icon">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div>
                            <span>User Pemohon</span>
                            <h3>{{ $stats['user'] }}</h3>
                        </div>
                        <i class="bi bi-person-fill card-decoration"></i>
                    </div>
                </div>
            </div>

            <!-- Filter & Search Toolbar -->
            <form method="GET" action="{{ route('admin.users.index') }}" class="filter-wrapper animate-item mb-4">
                <div class="filter-search flex-grow-1">
                    <i class="bi bi-search"></i>
                    <input
                        type="text"
                        name="search"
                        placeholder="Cari nama, email, atau no handphone..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="filter-dropdown">
                    <select name="role" onchange="this.form.submit()">
                        <option value="">Semua Role</option>
                        <option value="Admin" {{ request('role') === 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="User" {{ request('role') === 'User' ? 'selected' : '' }}>User</option>
                    </select>
                    <i class="bi bi-chevron-down"></i>
                </div>

                <div class="filter-dropdown">
                    <select name="status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ request('status') === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    <i class="bi bi-chevron-down"></i>
                </div>

                @if(request()->hasAny(['search', 'role', 'status']))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1" style="border-radius: 999px; font-size: 13px; padding: 0 16px;">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                @endif
            </form>

            <!-- Table Card -->
            <div class="table-card animate-item">
                <div class="table-responsive">
                    <table class="table application-table align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>No. Handphone</th>
                                <th>Role</th>
                                <th>Status Akun</th>
                                <th>Status Sesi / Login</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $u)
                                @php
                                    $isUserOnline = in_array($u->id, $onlineUserIds);
                                    $session = $recentSessions->get($u->id);
                                    $initial = strtoupper(substr($u->name, 0, 1));
                                @endphp
                                <tr>
                                    <td><strong>{{ $users->firstItem() + $index }}</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar-circle">
                                                {{ $initial }}
                                            </div>
                                            <div>
                                                <div class="fw-bold" style="color: var(--text);">{{ $u->name }}</div>
                                                <div class="text-muted" style="font-size: 12.5px;">{{ $u->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $u->no_hp ?? '-' }}</td>
                                    <td>
                                        @if($u->role === 'Admin' || $u->is_admin)
                                            <span class="role-badge-admin"><i class="bi bi-shield-fill me-1"></i> Admin</span>
                                        @else
                                            <span class="role-badge-user"><i class="bi bi-person me-1"></i> User</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($u->status === 'Nonaktif')
                                            <span class="status-badge-inactive"><i class="bi bi-dash-circle-fill me-1"></i> Nonaktif</span>
                                        @else
                                            <span class="status-badge-active"><i class="bi bi-check-circle-fill me-1"></i> Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($isUserOnline)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill" style="font-size: 12px;">
                                                <span class="online-dot me-1"></span> Online Sekarang
                                            </span>
                                            @if($session && $session->ip_address)
                                                <div class="text-muted" style="font-size: 11px;">IP: {{ $session->ip_address }}</div>
                                            @endif
                                        @else
                                            @if($session && $session->last_activity)
                                                <span class="text-muted" style="font-size: 12px;">
                                                    <i class="bi bi-clock-history me-1"></i> {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}
                                                </span>
                                            @else
                                                <span class="text-muted" style="font-size: 12px;">Belum pernah login</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <a href="{{ route('admin.users.show', $u->id) }}" class="btn btn-sm btn-light border px-2 py-1 text-decoration-none" title="Lihat Detail & Aktivitas" style="border-radius: 8px;">
                                                <i class="bi bi-eye text-primary"></i> Detail
                                            </a>
                                            <button type="button" class="btn btn-sm btn-light border px-2 py-1" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $u->id }}" title="Edit User" style="border-radius: 8px;">
                                                <i class="bi bi-pencil-square text-warning"></i>
                                            </button>
                                            @if(auth()->id() !== $u->id)
                                                <button type="button" class="btn btn-sm btn-light border px-2 py-1" data-bs-toggle="modal" data-bs-target="#deleteUserModal-{{ $u->id }}" title="Hapus User" style="border-radius: 8px;">
                                                    <i class="bi bi-trash text-danger"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- MODAL EDIT USER -->
                                <div class="modal fade" id="editUserModal-{{ $u->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form method="POST" action="{{ route('admin.users.update', $u->id) }}" class="modal-content border-0 shadow" style="border-radius: 20px;">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold" style="color: var(--forest);">Edit Pengguna: {{ $u->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold" style="font-size: 13px;">Nama Lengkap</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $u->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold" style="font-size: 13px;">Email</label>
                                                    <input type="email" name="email" class="form-control" value="{{ $u->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold" style="font-size: 13px;">No. Handphone</label>
                                                    <input type="text" name="no_hp" class="form-control" value="{{ $u->no_hp }}" placeholder="08xxxxxxxxxx">
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <label class="form-label fw-semibold" style="font-size: 13px;">Role Akses</label>
                                                        <select name="role" class="form-select" required>
                                                            <option value="User" {{ $u->role === 'User' ? 'selected' : '' }}>User (Pemohon)</option>
                                                            <option value="Admin" {{ ($u->role === 'Admin' || $u->is_admin) ? 'selected' : '' }}>Admin (Pengelola)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label fw-semibold" style="font-size: 13px;">Status Akun</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="Aktif" {{ $u->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                            <option value="Nonaktif" {{ $u->status === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
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
                                                <button type="submit" class="btn text-white fw-bold" style="background: var(--forest); border-radius: 999px;">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- MODAL HAPUS USER -->
                                @if(auth()->id() !== $u->id)
                                <div class="modal fade" id="deleteUserModal-{{ $u->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" class="modal-content border-0 shadow text-center p-3" style="border-radius: 20px;">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body">
                                                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; border-radius: 50%; background: #FEE2E2; color: #DC2626; font-size: 26px;">
                                                    <i class="bi bi-trash-fill"></i>
                                                </div>
                                                <h5 class="fw-bold mb-2">Hapus Akun Pengguna?</h5>
                                                <p class="text-muted mb-4" style="font-size: 14px;">
                                                    Akun <strong>{{ $u->name }}</strong> ({{ $u->email }}) akan dihapus secara permanen dari sistem. Tindakan ini tidak dapat dibatalkan.
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

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-person-x" style="font-size: 36px; color: var(--sage);"></i>
                                        <div class="mt-2 fw-semibold">Tidak ada data pengguna ditemukan</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="table-footer d-flex justify-content-between align-items-center flex-wrap gap-2 p-3">
                    <span class="text-muted" style="font-size: 13.5px;">
                        Menampilkan {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} pengguna
                    </span>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

        </section>
    </main>
</div>

<!-- MODAL TAMBAH USER BARU -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.users.store') }}" class="modal-content border-0 shadow" style="border-radius: 20px;">
            @csrf
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="color: var(--forest);">
                    <i class="bi bi-person-plus-fill me-2"></i> Tambah User Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Muhammad Farhan" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Alamat Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="contoh@domain.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">No. Handphone / WhatsApp</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx">
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold" style="font-size: 13px;">Role Akses <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="User" selected>User (Pemohon)</option>
                            <option value="Admin">Admin (Pengelola)</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold" style="font-size: 13px;">Status Akun <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Password Default <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 999px;">Batal</button>
                <button type="submit" class="btn text-white fw-bold" style="background: var(--forest); border-radius: 999px;">Simpan User Baru</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const mobileMenuBtn = document.getElementById("mobileMenuBtn");
    const sidebar = document.querySelector(".sidebar");
    const sidebarCloseBtn = document.getElementById("sidebarCloseBtn");
    const menuIcon = document.getElementById("menuIcon");

    if (mobileMenuBtn && sidebar) {
        mobileMenuBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            sidebar.classList.toggle("mobile-open");
            if (menuIcon) {
                menuIcon.classList.toggle("bi-list");
                menuIcon.classList.toggle("bi-x-lg");
            }
        });
    }

    if (sidebarCloseBtn && sidebar) {
        sidebarCloseBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            sidebar.classList.remove("mobile-open");
            if (menuIcon) {
                menuIcon.classList.add("bi-list");
                menuIcon.classList.remove("bi-x-lg");
            }
        });
    }
</script>
</body>
</html>

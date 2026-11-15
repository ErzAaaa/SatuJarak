<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Satu Jarak - Manage Pengajuan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin/managePengajuan.css') }}">
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
                <span>Kelola Pengguna</span>
            </a> --}}

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


    <!-- Main -->
    <main class="main-content">

        <!-- Header -->
        <header class="top-header">

            <div class="mobile-menu">
                <button class="btn" id="mobileMenuBtn">
                    <i class="bi bi-list" id="menuIcon"></i>
                </button>
            </div>

            <div class="header-right">

                <div class="global-search">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search...">
                </div>


                <!-- Notification -->
                <div class="header-dropdown">

                    <button class="header-icon notification-btn" id="notificationBtn">
                        <i class="bi bi-bell-fill"></i>
                        <span class="notification-dot"></span>
                    </button>

                    <div class="notification-dropdown" id="notificationDropdown">

                        <div class="notification-header">
                            <strong>Notifikasi</strong>
                            <a href="#">Lihat Semua</a>
                        </div>

                        <div class="notification-item">
                            <div class="notification-dot-item pink"></div>

                            <div>
                                <strong>Pengajuan PGJ-004</strong>
                                <p>telah berubah menjadi Sedang Diproses</p>
                                <small>2 jam yang lalu</small>
                            </div>
                        </div>

                        <div class="notification-item">
                            <div class="notification-dot-item green"></div>

                            <div>
                                <strong>Pengajuan PGJ-003</strong>
                                <p>telah selesai</p>
                                <small>5 jam yang lalu</small>
                            </div>
                        </div>

                        <div class="notification-item">
                            <div class="notification-dot-item gold"></div>

                            <div>
                                <strong>Pengajuan PGJ-002</strong>
                                <p>menunggu verifikasi</p>
                                <small>1 hari yang lalu</small>
                            </div>
                        </div>

                    </div>

                </div>


                <!-- Profile -->
                <div class="header-dropdown">

                    <button class="profile-btn" id="profileBtn">
                        <div class="profile-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <i class="bi bi-chevron-down profile-arrow"></i>
                    </button>

                    <div class="profile-dropdown" id="profileDropdown">

                        <div class="profile-info">
                            <div class="profile-avatar large">
                                <i class="bi bi-person-fill"></i>
                            </div>

                            <div>
                                <strong>Admin Desa</strong>
                                <small>Administrator</small>
                            </div>
                        </div>

                        <hr>

                        <a href="#">
                            <i class="bi bi-person"></i>
                            Profil
                        </a>

                        <a href="#">
                            <i class="bi bi-box-arrow-right"></i>
                            Log Out
                        </a>

                    </div>

                </div>

            </div>

        </header>


        <!-- Content -->
        <section class="content">

            <!-- Page Heading -->
            <div class="page-heading animate-item">

                <div>
                    <span class="heading-label">
                        ADMINISTRASI DESA
                    </span>

                    <h1>Manage Pengajuan</h1>

                    <p>
                        Pantau dan kelola pengajuan masyarakat Desa Jarak
                    </p>
                </div>

                <div class="heading-decoration">
                    <i class="bi bi-file-earmark-check-fill"></i>
                </div>

            </div>

            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-3 animate-item" style="border-radius: 12px; font-size: 14px;">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-3 animate-item" style="border-radius: 12px; font-size: 14px;">
                    <i class="bi bi-exclamation-circle-fill fs-5"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif


            <!-- Pengajuan Banner -->
            <div class="submission-banner animate-item">

                <div class="banner-decoration decoration-one"></div>
                <div class="banner-decoration decoration-two"></div>

                <div class="banner-icon">
                    <i class="bi bi-clipboard-check-fill"></i>
                </div>

                <div class="banner-content">
                    <span>DATA PENGAJUAN</span>

                    <h2>Pengajuan</h2>

                    <p>
                        <strong id="totalBanner">{{ $stats['total'] }}</strong>
                        pengajuan terdaftar
                    </p>
                </div>

                <div class="month-select">

                    <i class="bi bi-calendar3"></i>

                    <select id="monthFilter">
                        <option>September 2026</option>
                        <option>Agustus 2026</option>
                        <option>Juli 2026</option>
                    </select>

                    <i class="bi bi-chevron-down"></i>

                </div>

            </div>


            <!-- Statistic Cards -->
            <div class="row g-3 statistic-row">

                <div class="col-12 col-sm-6 col-xl-3">

                    <div class="stat-card stat-total animate-item">

                        <div class="stat-icon">
                           <i class="bi bi-file-earmark-text-fill"></i>
                        </div>

                        <div>
                            <span>Total Pengajuan</span>
                            <h3 id="totalApplication">{{ $stats['total'] }}</h3>
                        </div>

                        <i class="bi bi-file-earmark-text-fill card-decoration"></i>

                    </div>

                </div>


                <div class="col-12 col-sm-6 col-xl-3">

                    <div class="stat-card stat-waiting animate-item">

                        <div class="stat-icon">
                            <i class="bi bi-clock-fill"></i>
                        </div>

                        <div>
                            <span>Menunggu Verifikasi</span>
                            <h3 id="waitingApplication">{{ $stats['menunggu'] }}</h3>
                        </div>

                        <i class="bi bi-hourglass-split card-decoration"></i>

                    </div>

                </div>


                <div class="col-12 col-sm-6 col-xl-3">

                    <div class="stat-card stat-process animate-item">

                        <div class="stat-icon">
                            <i class="bi bi-gear-fill"></i>
                        </div>

                        <div>
                            <span>Sedang Diproses</span>
                            <h3 id="processApplication">{{ $stats['proses'] }}</h3>
                        </div>

                        <i class="bi bi-arrow-repeat card-decoration"></i>

                    </div>

                </div>


                <div class="col-12 col-sm-6 col-xl-3">

                    <div class="stat-card stat-complete animate-item">

                        <div class="stat-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>

                        <div>
                            <span>Selesai</span>
                            <h3 id="completeApplication">{{ $stats['selesai'] }}</h3>
                        </div>

                        <i class="bi bi-check-circle card-decoration"></i>

                    </div>

                </div>

            </div>


            <!-- Filter -->
            <div class="filter-wrapper animate-item">

                <div class="filter-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari pengajuan..."
                        value="{{ request('search') }}"
                    >

                </div>


                <div class="filter-select-wrapper status-filter">

                    <i class="bi bi-list-ul"></i>

                    <select id="statusFilter">
                        <option value="">Status</option>
                        <option value="Menunggu Verifikasi" {{ request('status') === 'Menunggu Verifikasi' ? 'selected' : '' }}>
                            Menunggu Verifikasi
                        </option>
                        <option value="Sedang Diproses" {{ request('status') === 'Sedang Diproses' ? 'selected' : '' }}>
                            Sedang Diproses
                        </option>
                        <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>
                        <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>
                            Ditolak
                        </option>
                    </select>

                    <i class="bi bi-chevron-down"></i>

                </div>


                <div class="filter-select-wrapper service-filter">

                    <i class="bi bi-grid-3x3-gap-fill"></i>

                    <select id="serviceFilter">
                        <option value="">Layanan</option>
                        <option value="KKN" {{ request('layanan') === 'KKN' ? 'selected' : '' }}>KKN</option>
                        <option value="Penelitian" {{ request('layanan') === 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                        <option value="Administrasi" {{ request('layanan') === 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                        <option value="Kependudukan" {{ request('layanan') === 'Kependudukan' ? 'selected' : '' }}>Kependudukan</option>
                        <option value="Surat Keterangan" {{ request('layanan') === 'Surat Keterangan' ? 'selected' : '' }}>
                            Surat Keterangan
                        </option>
                    </select>

                    <i class="bi bi-chevron-down"></i>

                </div>

            </div>


            <!-- Table -->
            <div class="table-card animate-item">
                <div class="table-responsive">
                    <table class="table application-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pemohon</th>
                                <th>Judul Kerjasama</th>
                                <th>Nama Instansi</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody id="applicationTable">
                            @forelse ($pengajuans as $item)
                                @php
                                    $kode = 'PGJ-' . str_pad($item->id, 3, '0', STR_PAD_LEFT);
                                    $statusClass = match($item->status) {
                                        'Menunggu Verifikasi' => 'waiting',
                                        'Sedang Diproses' => 'process',
                                        'Selesai' => 'completed',
                                        'Ditolak' => 'rejected',
                                        default => 'waiting',
                                    };
                                @endphp
                                <tr>
                                    <td><strong>{{ $kode }}</strong></td>
                                    <td>{{ $item->nama_lengkap ?? ($item->user->name ?? '-') }}</td>
                                    <td>{{ $item->judul_kerjasama ?? $item->jenis_kegiatan ?? '-' }}</td>
                                    <td>{{ $item->nama_instansi ?? $item->universitas ?? '-' }}</td>
                                    <td>{{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : '-' }}</td>
                                    <td>
                                        <span class="status-badge {{ $statusClass }}">
                                            <i class="bi bi-circle-fill"></i>
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.pengajuan.show', $item->id) }}" class="detail-btn">
                                            Detail <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        Belum ada data pengajuan permohonan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                <!-- Table Footer -->
                <div class="table-footer">

                    <span id="dataInfo">
                        @if($pengajuans->total() > 0)
                            Menampilkan {{ $pengajuans->firstItem() }}&ndash;{{ $pengajuans->lastItem() }} dari {{ $pengajuans->total() }} pengajuan
                        @else
                            Tidak ada pengajuan ditemukan
                        @endif
                    </span>

                    @if($pengajuans->hasPages())
                        <nav>
                            <ul class="pagination" id="pagination">
                                {{-- Prev --}}
                                @if($pengajuans->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pengajuans->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
                                    </li>
                                @endif

                                {{-- Page numbers --}}
                                @foreach($pengajuans->getUrlRange(1, $pengajuans->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $pengajuans->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- Next --}}
                                @if($pengajuans->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pengajuans->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @else
                        <nav><ul class="pagination" id="pagination"></ul></nav>
                    @endif

                </div>

            </div>

        </section>

    </main>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Inject data dari database untuk dipakai managePengajuan.js --}}
<script>
    window.appStats = {
        total:    {{ $stats['total'] }},
        menunggu: {{ $stats['menunggu'] }},
        proses:   {{ $stats['proses'] }},
        selesai:  {{ $stats['selesai'] }},
    };
    window.appData = @json($pengajuans->items());
    window.appPagination = {
        currentPage: {{ $pengajuans->currentPage() }},
        lastPage:    {{ $pengajuans->lastPage() }},
        total:       {{ $pengajuans->total() }},
        perPage:     {{ $pengajuans->perPage() }},
    };
</script>

<script src="{{ asset('js/admin/managePengajuan.js') }}"></script>

</body>
</html>
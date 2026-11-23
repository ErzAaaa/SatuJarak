<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potensi Desa - Satu Jarak</title>
    <!-- Favicon / Logo Satu Jarak -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --forest: #0B3828;
            --forest-light: #15533F;
            --mint: #70C69B;
            --sage: #A7B998;
            --gold: #D9A36A;
            --gold-light: #F9E1B9;
            --text: #173D30;
            --muted: #708078;
            --border: #E5ECE8;
            --mint-soft: #DCEFE6;
            --background: #F7FAF8;
            --white: #FFFFFF;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Inter", "Segoe UI", Arial, sans-serif;
            background: var(--background);
            color: var(--text);
            font-size: 15px;
            line-height: 1.5;
        }

        button,
        input,
        select { font-family: inherit; }

        /* SIDEBAR */
        .sidebar {
            width: 280px; min-height: 100vh; padding: 30px 24px;
            background: var(--forest);
            display: flex; flex-direction: column;
            position: fixed; left: 0; top: 0; bottom: 0;
            z-index: 1000; overflow-x: hidden; overflow-y: auto;
        }
        .sidebar::before {
            content: ""; position: absolute; width: 230px; height: 230px; border-radius: 50%;
            background: rgba(112, 198, 155, 0.10); left: -110px; bottom: 40px; pointer-events: none;
        }
        .sidebar::after {
            content: ""; position: absolute; width: 180px; height: 180px; border-radius: 50%;
            background: rgba(217, 163, 106, 0.10); left: -90px; bottom: -50px; pointer-events: none;
        }
        .sidebar > * { position: relative; z-index: 2; }

        .brand { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 0; margin-bottom: 38px; }
        .brand-icon {
            width: 82px; height: 82px; margin: auto; border-radius: 25px;
            background: linear-gradient(145deg, var(--gold), var(--mint));
            display: flex; align-items: center; justify-content: center;
            color: var(--forest); font-size: 40px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.16);
            flex-shrink: 0; animation: logoFloat 4s ease-in-out infinite;
        }
        .brand-icon img { width: 100px; height: 100px; object-fit: contain; }
        @keyframes logoFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
        @media (prefers-reduced-motion: reduce) { .brand-icon { animation: none; } }
        .brand-name { color: #FFFFFF; font-size: 27px; font-weight: 800; line-height: 1.2; margin: 12px 0 1px; }
        .brand-sub { color: #D4E7DF; font-size: 12px; margin: 0; }

        .nav-list { list-style: none; padding: 0; margin: 0; flex: 1; display: flex; flex-direction: column; gap: 11px; }
        .nav-link {
            min-height: 46px; padding: 0 18px; border-radius: 30px;
            background: rgba(255, 255, 255, 0.96); color: var(--text);
            display: flex; align-items: center; gap: 13px;
            font-size: 15px; font-weight: 700; transition: all 0.25s ease; text-decoration: none;
        }
        .nav-link i { font-size: 17px; }
        .nav-link:hover { transform: translateX(5px); background: var(--mint); color: var(--forest); }
        .nav-link.active { background: var(--gold); color: var(--forest); box-shadow: 0 8px 18px rgba(217, 163, 106, 0.22); }
        .nav-link.active::after { content: "\F285"; font-family: "bootstrap-icons"; margin-left: auto; }

        .help-card { background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.14); border-radius: 20px; padding: 20px 18px; margin-top: 18px; }
        .help-title { display: flex; align-items: center; gap: 10px; color: #FFFFFF; font-weight: 800; font-size: 14.5px; margin-bottom: 14px; }
        .help-title-icon { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(145deg, var(--gold), var(--mint)); color: var(--forest); display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; }
        .help-section-label { color: rgba(255,255,255,0.55); font-size: 10.5px; font-weight: 800; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 8px; }
        .help-schedule { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
        .help-schedule-row { display: flex; align-items: baseline; justify-content: space-between; gap: 10px; font-size: 11.5px; }
        .help-day { color: #FFFFFF; font-weight: 700; }
        .help-hours { color: rgba(255,255,255,0.65); font-weight: 600; white-space: nowrap; }
        .help-divider { height: 1px; background: rgba(255,255,255,0.12); margin: 14px 0; border: none; }
        .help-contact { display: flex; flex-direction: column; gap: 10px; }
        .help-contact-link { display: flex; align-items: center; gap: 10px; color: #FFFFFF; font-size: 11.5px; font-weight: 600; border-radius: 10px; padding: 6px 8px; margin: -6px -8px; transition: background 0.15s ease; white-space: nowrap; text-decoration: none; }
        .help-contact-link:hover { background: rgba(255,255,255,0.08); }
        .help-contact-link i { width: 26px; height: 26px; border-radius: 50%; background: rgba(255,255,255,0.10); color: var(--mint); display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; }

        .sidebar-backdrop { display: none; }

        /* AREA KONTEN */
        .main-content {
            min-height: 100vh;
            margin-left: 280px;
            padding: 30px 34px 40px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .topbar-toggle {
            width: 46px; height: 46px; border-radius: 50%; border: none;
            background: #EEF4F0; color: var(--forest); font-size: 24px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }

        .page-heading h1 {
            margin: 0;
            color: var(--forest);
            font-size: 28px;
            font-weight: 800;
        }

        .page-heading p {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .user-label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border: 1px solid #E2EAE3;
            border-radius: 30px;
            background: var(--white);
            color: var(--forest);
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .user-avatar {
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--mint);
            font-size: 18px;
        }

        /* BANNER */
        .welcome-banner {
            position: relative;
            padding: 28px 30px;
            margin-bottom: 27px;
            overflow: hidden;
            border-radius: 22px;
            background: linear-gradient(120deg, var(--forest), #236747);
            color: var(--white);
        }

        .welcome-banner::after {
            content: "";
            position: absolute;
            top: -65px;
            right: -30px;
            width: 210px;
            height: 210px;
            border: 35px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .welcome-banner h2 {
            position: relative;
            z-index: 1;
            margin: 0 0 10px;
            font-size: 23px;
            font-weight: 800;
        }

        .welcome-banner p {
            position: relative;
            z-index: 1;
            max-width: 650px;
            margin: 0;
            color: #DCEBE1;
            font-size: 13px;
            line-height: 1.8;
        }

        /* PENCARIAN */
        .search-panel {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px;
            margin-bottom: 25px;
            border: 1px solid #E6ECE6;
            border-radius: 18px;
            background: var(--white);
            box-shadow: 0 5px 20px rgba(20, 50, 30, 0.03);
        }

        .search-box {
            position: relative;
            flex: 1;
        }

        .search-box i {
            position: absolute;
            top: 50%;
            left: 15px;
            color: var(--muted);
            transform: translateY(-50%);
        }

        .search-box input {
            width: 100%;
            min-height: 45px;
            padding: 12px 18px 12px 43px;
            border: 1px solid #E0E8E0;
            border-radius: 999px;
            outline: none;
            background: #FAFCFA;
            font-size: 13px;
        }

        .search-box input:focus {
            border-color: #6BA883;
            box-shadow: 0 0 0 3px rgba(107, 168, 131, 0.12);
        }

        .filter-select {
            min-width: 180px;
            min-height: 45px;
            padding: 10px 18px;
            border: 1px solid #E0E8E0;
            border-radius: 999px;
            background: var(--white);
            color: var(--text);
            font-size: 13px;
            outline: none;
        }

        /* JUDUL BAGIAN */
        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 17px;
        }

        .section-heading h2 {
            margin: 0;
            color: var(--forest);
            font-size: 19px;
            font-weight: 800;
        }

        .result-count {
            color: var(--muted);
            font-size: 12px;
        }

        /* KARTU POTENSI */
        .potential-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
        }

        .potential-card {
            overflow: hidden;
            border: 1px solid #E6ECE6;
            border-radius: 19px;
            background: var(--white);
            box-shadow: 0 6px 20px rgba(20, 50, 30, 0.035);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .potential-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 13px 28px rgba(20, 50, 30, 0.09);
        }

        .card-visual {
            display: grid;
            place-items: center;
            height: 155px;
            background: linear-gradient(135deg, #DDEFE1, #F0F6E8);
            color: var(--forest);
            font-size: 48px;
        }

        .card-visual.gold {
            background: linear-gradient(135deg, #F4E7C1, #FBF5E5);
        }

        .card-visual.blue {
            background: linear-gradient(135deg, #DDEBF0, #EFF6F7);
        }

        .card-body-custom {
            padding: 20px;
        }

        .category-badge {
            display: inline-block;
            padding: 6px 10px;
            margin-bottom: 12px;
            border-radius: 20px;
            background: #E6F4EA;
            color: #286341;
            font-size: 10px;
            font-weight: 800;
        }

        .category-badge.gold {
            background: #FAF0D6;
            color: #87631A;
        }

        .category-badge.blue {
            background: #E5F0F4;
            color: #326478;
        }

        .card-body-custom h3 {
            margin: 0 0 9px;
            color: var(--forest);
            font-size: 17px;
            font-weight: 800;
        }

        .card-description {
            min-height: 60px;
            margin: 0 0 17px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .card-footer-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding-top: 14px;
            border-top: 1px solid #EDF1ED;
        }

        .location-label {
            color: var(--muted);
            font-size: 11px;
        }

        .detail-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #246B45;
            font-size: 11px;
            font-weight: 800;
            text-decoration: none;
        }

        .detail-link:hover {
            color: var(--forest);
        }

        .empty-state {
            display: none;
            padding: 40px 20px;
            border: 1px dashed #C9D8CC;
            border-radius: 18px;
            background: var(--white);
            color: var(--muted);
            text-align: center;
        }

        .empty-state i {
            display: block;
            margin-bottom: 12px;
            color: #9BB5A2;
            font-size: 35px;
        }

        .empty-state h3 {
            color: var(--forest);
            font-size: 17px;
            font-weight: 800;
        }

        .empty-state p {
            margin-bottom: 0;
            font-size: 12px;
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .main-content {
                padding-right: 25px;
                padding-left: 25px;
            }
        }

        @media (max-width: 850px) {
            .potential-grid { grid-template-columns: 1fr; }
            .search-panel { align-items: stretch; flex-direction: column; }
            .filter-select { width: 100%; }
        }

        @media (max-width: 600px) {
            .main-content { margin-left: 0; padding: 24px 16px; }
            .topbar { align-items: flex-start; flex-direction: column; margin-bottom: 22px; }
            .page-heading h1 { font-size: 24px; }
            .welcome-banner { padding: 23px 20px; }
            .welcome-banner h2 { font-size: 20px; }
            .potential-grid { grid-template-columns: 1fr; }
        }

        /* SIDEBAR RESPONSIVE (sama seperti user pengajuan) */
        @media (max-width: 992px) {
            .main-content { margin-left: 0; }
            .sidebar { left: -300px; transition: left 0.2s ease; box-shadow: 10px 0 30px rgba(0,0,0,0.2); }
            .sidebar.open { left: 0; }
            .sidebar.open + .sidebar-backdrop { display: block; position: fixed; inset: 0; background: rgba(11,56,40,0.45); z-index: 999; }
        }
        @media (max-width: 576px) {
            .sidebar { width: 260px; left: -280px; padding: 24px 18px; }
        }
    </style>
</head>

<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon"><img src="{{ asset('images/logo.png') }}" alt="Logo SatuJarak"></div>
            <div>
                <div class="brand-name">Satu Jarak</div>
                <div class="brand-sub">Pelayanan Publik Desa</div>
            </div>
        </div>

        <ul class="nav-list">
            <li><a href="{{ route('home') }}" class="nav-link"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
            <li><a href="{{ route('potensi') }}" class="nav-link active"><i class="bi bi-stars"></i> Potensi Desa</a></li>
            <li><a href="{{ route('pengajuan.index', ['action' => 'list']) }}" class="nav-link"><i class="bi bi-clock-history"></i> Riwayat Pengajuan</a></li>
            <li><a href="{{ route('pengajuan.index', ['action' => 'create']) }}" class="nav-link"><i class="bi bi-plus-circle-fill"></i> Buat Pengajuan</a></li>
        </ul>

        <div class="help-card">
            <div class="help-title">
                <span class="help-title-icon"><i class="bi bi-headset"></i></span>
                Butuh Bantuan?
            </div>
            <div class="help-section-label">Jam Operasional Kantor Desa</div>
            <div class="help-schedule">
                <div class="help-schedule-row"><span class="help-day">Senin - Kamis</span><span class="help-hours">08.00 - 13.00 WIB</span></div>
                <div class="help-schedule-row"><span class="help-day">Jumat</span><span class="help-hours">08.00 - 11.00 WIB</span></div>
            </div>
            <hr class="help-divider">
            <div class="help-contact">
                <a href="mailto:desajarak204@gmail.com" class="help-contact-link"><i class="bi bi-envelope-fill"></i> desajarak204@gmail.com</a>
                <a href="https://instagram.com/ds.jarak" target="_blank" rel="noopener" class="help-contact-link"><i class="bi bi-instagram"></i> @ds.jarak</a>
            </div>
        </div>
    </aside>
    <div class="sidebar-backdrop"></div>

    <!-- KONTEN UTAMA -->
    <main class="main-content">
        <header class="topbar">
            <div style="display:flex; align-items:center; gap:12px;">
                <button class="topbar-toggle d-lg-none" data-sidebar-toggle aria-label="Buka menu"><i class="bi bi-list"></i></button>
                <div class="page-heading">
                    <h1>Potensi Desa</h1>
                    <p>Kenali potensi, produk, dan keunggulan Desa Jarak.</p>
                </div>
            </div>

            <div class="user-label">
                <span class="user-avatar">
                    <i class="bi bi-person"></i>
                </span>
                <span>Pengunjung</span>
            </div>
        </header>

        <!-- BANNER SAMBUTAN -->
        <section class="welcome-banner">
            <h2>Jelajahi Potensi Desa Jarak</h2>
            <p>
                Temukan berbagai potensi unggulan desa, mulai dari produk
                UMKM hingga potensi wisata yang dapat
                dikembangkan untuk meningkatkan kesejahteraan masyarakat.
            </p>
        </section>

        <!-- PENCARIAN DAN FILTER -->
        <section class="search-panel">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari nama potensi atau deskripsi..."
                    aria-label="Cari potensi desa"
                >
            </div>

            <select
                id="categoryFilter"
                class="filter-select"
                aria-label="Filter kategori potensi"
            >
                <option value="all">Semua Kategori</option>
                <option value="umkm">UMKM</option>
                <option value="wisata">Wisata</option>
            </select>
        </section>

        <!-- DAFTAR POTENSI -->
        <section>
            <div class="section-heading">
                <h2>Potensi Unggulan</h2>
                <span class="result-count" id="resultCount">
                    2 potensi ditemukan
                </span>
            </div>

            <div class="potential-grid" id="potentialGrid">
                <!-- KARTU 1 -->
                <article
                    class="potential-card"
                    data-category="umkm"
                    data-search="umkm produk olahan makanan usaha masyarakat desa"
                >
                    <div class="card-visual gold">
                        <i class="bi bi-shop"></i>
                    </div>

                    <div class="card-body-custom">
                        <span class="category-badge gold">UMKM</span>
                        <h3>Produk UMKM Desa</h3>
                        <p class="card-description">
                            Produk usaha masyarakat desa yang berpotensi
                            dikembangkan dan dipasarkan secara lebih luas.
                        </p>

                        <div class="card-footer-custom">
                            <span class="location-label">
                                <i class="bi bi-geo-alt"></i>
                                Desa Jarak
                            </span>

                            <a
                                href="{{ route('laman-umkm') }}"
                                class="detail-link"
                            >
                                Lihat Detail
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>

                <!-- KARTU 2 -->
                <article
                    class="potential-card"
                    data-category="wisata"
                    data-search="wisata alam pemandangan lingkungan desa"
                >
                    <div class="card-visual blue">
                        <i class="bi bi-tree"></i>
                    </div>

                    <div class="card-body-custom">
                        <span class="category-badge blue">Wisata</span>
                        <h3>Potensi Wisata Desa</h3>
                        <p class="card-description">
                            Potensi lingkungan dan keindahan alam desa
                            yang dapat menjadi daya tarik pengunjung.
                        </p>

                        <div class="card-footer-custom">
                            <span class="location-label">
                                <i class="bi bi-geo-alt"></i>
                                Desa Jarak
                            </span>

                            <a
                                href="{{ route('wisata.index') }}"
                                class="detail-link"
                            >
                                Lihat Detail
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- TAMPIL JIKA HASIL PENCARIAN KOSONG -->
            <div class="empty-state" id="emptyState">
                <i class="bi bi-search"></i>
                <h3>Potensi tidak ditemukan</h3>
                <p>
                    Coba gunakan kata kunci lain atau pilih kategori berbeda.
                </p>
            </div>
        </section>
    </main>

    <script>
        const sidebarEl = document.querySelector('.sidebar');
        document.querySelector('[data-sidebar-toggle]')?.addEventListener('click', () => sidebarEl.classList.toggle('open'));
        document.querySelector('.sidebar-backdrop')?.addEventListener('click', () => sidebarEl.classList.remove('open'));

        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const potentialCards = document.querySelectorAll('.potential-card');
        const resultCount = document.getElementById('resultCount');
        const emptyState = document.getElementById('emptyState');
        const potentialGrid = document.getElementById('potentialGrid');

        function filterPotentials() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const selectedCategory = categoryFilter.value;
            let visibleCount = 0;

            potentialCards.forEach((card) => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('.card-description').textContent.toLowerCase();
                const searchableText = card.dataset.search.toLowerCase();

                const matchesSearch =
                    title.includes(searchTerm) ||
                    description.includes(searchTerm) ||
                    searchableText.includes(searchTerm);

                const matchesCategory =
                    selectedCategory === 'all' ||
                    card.dataset.category === selectedCategory;

                const isVisible = matchesSearch && matchesCategory;

                card.style.display = isVisible ? '' : 'none';

                if (isVisible) {
                    visibleCount++;
                }
            });

            resultCount.textContent = `${visibleCount} potensi ditemukan`;
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            potentialGrid.style.display = visibleCount === 0 ? 'none' : 'grid';
        }

        searchInput.addEventListener('input', filterPotentials);
        categoryFilter.addEventListener('change', filterPotentials);
    </script>
</body>
</html>
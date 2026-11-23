<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Sumber Ubalan - Satu Jarak</title>
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
            --hover-green: #2E5A43;
            --mint: #70C69B;
            --sage: #A7B998;
            --gold: #D9A36A;
            --gold-light: #F9E1B9;
            --sky: #4F8EA6;
            --sky-light: #E5F0F4;
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

        /* ============================================================
           SIDEBAR (sama persis dengan user pengajuan & potensi desa)
           ============================================================ */
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

        /* ============================================================
           AREA KONTEN
           ============================================================ */
        .main-content {
            min-height: 100vh;
            margin-left: 280px;
            padding: 30px 34px 50px;
        }

        .topbar-toggle {
            width: 46px; height: 46px; border-radius: 50%; border: none;
            background: #EEF4F0; color: var(--forest); font-size: 24px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            margin-bottom: 18px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .back-link:hover { color: var(--forest); }

        /* ============================================================
           HERO
           ============================================================ */
        .detail-hero {
            position: relative;
            height: 340px;
            margin-bottom: 22px;
            border-radius: 24px;
            overflow: hidden;
            background: linear-gradient(135deg, #DDEBF0, #EFF6F7);
        }

        .detail-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .detail-hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(11, 56, 40, 0.80) 0%, rgba(11, 56, 40, 0.18) 55%, rgba(11, 56, 40, 0) 100%);
        }

        .detail-hero-text {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            padding: 26px 32px;
            color: var(--white);
        }

        .detail-category-badge {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 10px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.18);
            color: var(--white);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.3px;
            backdrop-filter: blur(2px);
        }

        .detail-hero-tagline {
            display: block;
            margin-bottom: 4px;
            color: var(--gold);
            font-size: 13.5px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .detail-hero-text h1 {
            margin: 0 0 10px;
            font-size: 40px;
            font-weight: 800;
            line-height: 1.1;
        }

        .detail-hero-location {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13.5px;
            color: #E4EFE8;
        }

        /* ============================================================
           QUICK INFO BAR — tiket, jam, lokasi, tombol maps
           ============================================================ */
        .quick-info-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr) auto;
            gap: 16px;
            align-items: stretch;
            padding: 20px 24px;
            margin-bottom: 28px;
            border: 1px solid #E6ECE6;
            border-radius: 20px;
            background: var(--white);
            box-shadow: 0 6px 20px rgba(20, 50, 30, 0.035);
        }

        .quick-info-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .quick-info-item + .quick-info-item {
            padding-left: 16px;
            border-left: 1px solid #EDF1ED;
        }

        .quick-info-icon {
            flex-shrink: 0;
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            font-size: 17px;
        }

        .quick-info-icon.gold { background: #FAF0D6; color: #87631A; }
        .quick-info-icon.green { background: #E6F4EA; color: #286341; }
        .quick-info-icon.blue { background: var(--sky-light); color: var(--sky); }

        .quick-info-label {
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 3px;
        }

        .quick-info-value {
            color: var(--text);
            font-size: 13.5px;
            font-weight: 700;
            line-height: 1.5;
        }

        .quick-info-value small {
            display: block;
            color: var(--muted);
            font-size: 11.5px;
            font-weight: 500;
            margin-top: 2px;
        }

        .maps-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 24px;
            border: none;
            border-radius: 999px;
            background: var(--forest);
            color: var(--white);
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .maps-btn:hover { background: var(--hover-green); color: var(--white); }

        /* ============================================================
           LAYOUT 2 KOLOM — konten kiri, galeri kanan
           ============================================================ */
        .detail-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 24px;
            align-items: start;
        }

        .detail-card {
            padding: 26px 28px;
            margin-bottom: 24px;
            border: 1px solid #E6ECE6;
            border-radius: 20px;
            background: var(--white);
            box-shadow: 0 6px 20px rgba(20, 50, 30, 0.035);
        }

        .detail-card h2 {
            margin: 0 0 14px;
            color: var(--forest);
            font-size: 18px;
            font-weight: 800;
        }

        .detail-card p {
            margin: 0 0 14px;
            color: var(--text);
            font-size: 13.5px;
            line-height: 1.85;
        }

        .detail-card p:last-child { margin-bottom: 0; }

        /* ---------- Daftar aktivitas ---------- */
        .activity-item {
            display: flex;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px dashed #E3EAE3;
        }

        .activity-item:last-child { border-bottom: none; padding-bottom: 0; }
        .activity-item:first-child { padding-top: 4px; }

        .activity-number {
            flex-shrink: 0;
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 13px;
            background: var(--sky-light);
            color: var(--sky);
            font-size: 18px;
        }

        .activity-text h3 {
            margin: 0 0 5px;
            color: var(--forest);
            font-size: 14.5px;
            font-weight: 800;
        }

        .activity-text p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
        }

        /* ---------- Galeri (kolom kanan, sticky) ---------- */
        .gallery-sidebar {
            position: sticky;
            top: 24px;
        }

        .gallery-card {
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #E6ECE6;
            border-radius: 20px;
            background: var(--white);
            box-shadow: 0 6px 20px rgba(20, 50, 30, 0.035);
        }

        .gallery-card h2 {
            margin: 0 0 14px;
            color: var(--forest);
            font-size: 16px;
            font-weight: 800;
        }

        .gallery-photo {
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .gallery-photo:last-child { margin-bottom: 0; }

        .gallery-photo img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .gallery-photo:hover img {
            transform: scale(1.05);
        }

        /* ============================================================
           RESPONSIVE
           ============================================================ */
        @media (max-width: 1200px) {
            .main-content { padding-right: 25px; padding-left: 25px; }
            .detail-layout { grid-template-columns: 1fr; }
            .gallery-sidebar { position: static; }
            .quick-info-bar {
                grid-template-columns: repeat(2, 1fr);
            }
            .maps-btn {
                grid-column: 1 / -1;
                padding: 12px;
            }
        }

        @media (max-width: 600px) {
            .main-content { margin-left: 0; padding: 24px 16px; }
            .detail-hero { height: 220px; }
            .detail-hero-text { padding: 18px 20px; }
            .detail-hero-text h1 { font-size: 26px; }
            .detail-card { padding: 20px; }
            .quick-info-bar {
                grid-template-columns: 1fr;
                padding: 16px 18px;
            }
            .quick-info-item + .quick-info-item {
                padding-left: 0;
                padding-top: 14px;
                margin-top: 2px;
                border-left: none;
                border-top: 1px solid #EDF1ED;
            }
            .maps-btn { grid-column: auto; padding: 12px; }
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

        <button class="topbar-toggle d-lg-none" data-sidebar-toggle aria-label="Buka menu"><i class="bi bi-list"></i></button>

        <a href="{{ url('/potensi-desa') }}" class="back-link">
            <i class="bi bi-arrow-left"></i>
            Kembali ke Potensi Desa
        </a>

        <!-- HERO -->
        <div class="detail-hero">
            <img
                src="{{ asset('Potensi Desa/Wisata/sumber_ubalan_renang.webp') }}"
                alt="Kolam renang alami Sumber Ubalan"
            >
            <div class="detail-hero-text">
                <span class="detail-category-badge">Wisata</span>
                <h1>Sumber Ubalan</h1>
                <div class="detail-hero-location">
                    <i class="bi bi-geo-alt-fill"></i>
                    Dusun Kalasan, Desa Jarak, Kec. Plosoklaten, Kab. Kediri
                </div>
            </div>
        </div>

        <!-- QUICK INFO BAR -->
        <div class="quick-info-bar">
            <div class="quick-info-item">
                <div class="quick-info-icon gold"><i class="bi bi-ticket-perforated-fill"></i></div>
                <div>
                    <div class="quick-info-label">Harga Tiket</div>
                    <div class="quick-info-value">
                        Weekdays Rp4.000
                        <small>Weekend (Sab–Min) Rp10.000</small>
                    </div>
                </div>
            </div>

            <div class="quick-info-item">
                <div class="quick-info-icon green"><i class="bi bi-clock-fill"></i></div>
                <div>
                    <div class="quick-info-label">Jam Operasional</div>
                    <div class="quick-info-value">
                        08.00 – 17.00 WIB
                        <small>Buka setiap hari</small>
                    </div>
                </div>
            </div>

            <div class="quick-info-item">
                <div class="quick-info-icon blue"><i class="bi bi-geo-alt-fill"></i></div>
                <div>
                    <div class="quick-info-label">Lokasi</div>
                    <div class="quick-info-value">
                        Dusun Kalasan
                        <small>±18 km timur Kota Kediri</small>
                    </div>
                </div>
            </div>

            <a
                href="https://www.google.com/maps/search/?api=1&query=Sumber+Ubalan+Desa+Jarak+Plosoklaten+Kediri"
                target="_blank"
                rel="noopener"
                class="maps-btn"
            >
                <i class="bi bi-map-fill"></i>
                Buka Maps
            </a>
        </div>

        <!-- LAYOUT 2 KOLOM -->
        <div class="detail-layout">

            <!-- KOLOM KONTEN -->
            <div>
                <div class="detail-card">
                    <h2>Tentang Sumber Ubalan</h2>
                    <p>
                        Rasakan keasrian dan kemurnian alam yang menenangkan di Sumber Ubalan,
                        destinasi wisata air impian yang menyuguhkan kesegaran mata air pegunungan
                        alami sepanjang tahun. Berbeda dari objek wisata air konvensional, Sumber
                        Ubalan menawarkan kejernihan air yang memukau begitu bening hingga kawanan
                        ikan kecil terlihat menari indah di dalamnya.
                    </p>
                    <p>
                        Kaya akan mineral alami yang diyakini mampu menyegarkan kembali tubuh dan
                        pikiran, setiap bilasan airnya menghadirkan sensasi relaksasi yang nyata.
                        Tersembunyi jauh dari hiruk-pikuk perkotaan, tempat ini menyajikan suasana
                        yang tenang, damai, dan asri, menjadikannya suaka sempurna bagi Anda yang
                        merindukan kedamaian dan ingin melepas penat di dekapan alam.
                    </p>
                </div>

                <div class="detail-card">
                    <h2>Aktivitas Seru di Sumber Ubalan</h2>

                    <div class="activity-item">
                        <div class="activity-number"><i class="bi bi-water"></i></div>
                        <div class="activity-text">
                            <h3>1. Sensasi Berenang di Kolam Alami</h3>
                            <p>
                                Salah satu aktivitas favorit di sini adalah berenang di kolam alami
                                yang terisi air jernih dari mata air. Kolam-kolam tersebut dikelilingi
                                oleh pepohonan hijau dan batuan alam yang menambah keasrian suasana.
                            </p>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-number"><i class="bi bi-basket2-fill"></i></div>
                        <div class="activity-text">
                            <h3>2. Piknik</h3>
                            <p>
                                Bagi yang tidak ingin berenang, kamu masih bisa menikmati kesegaran
                                air dengan cara lainnya, seperti berendam di tepian kolam atau sekadar
                                mencelupkan kaki. Kamu juga bisa berpiknik di sekitar kolam bersama
                                orang-orang tersayang sambil menikmati bekal bawaan dan pemandangan
                                alam yang hijau.
                            </p>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-number"><i class="bi bi-fire"></i></div>
                        <div class="activity-text">
                            <h3>3. Camping</h3>
                            <p>
                                Bagi kamu yang ingin menghabiskan waktu lebih lama di Sumber Ubalan,
                                ada fasilitas camping ground atau area perkemahan yang sangat cocok
                                untuk kegiatan berkemah. Nikmati suasana alam di malam hari, dengarkan
                                suara alam yang menenangkan, dan tidur di bawah bintang.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="detail-card">
                    <h2>Lokasi dan Akses</h2>
                    <p>
                        Wisata Sumber Ubalan terletak di Dusun Kalasan, Desa Jarak, Kecamatan
                        Plosoklaten, Kabupaten Kediri, Jawa Timur. Lokasinya berada sekitar 18
                        kilometer ke arah timur dari pusat Kota Kediri, atau sekitar 30 menit
                        perjalanan menggunakan kendaraan pribadi.
                    </p>
                    <p>
                        Jika ingin mencapai Sumber Ubalan, kamu dapat memulai perjalanan dari
                        Simpang Lima Gumul, Kediri. Dari sana, ikuti jalan menuju Ubalan dan
                        teruskan perjalanan hingga mencapai lokasi wisata. Jalan menuju Sumber
                        Ubalan cukup mudah diakses dan cocok untuk kendaraan roda dua maupun
                        roda empat.
                    </p>
                    <p>
                        Bagi kamu yang tidak membawa kendaraan pribadi, tersedia layanan
                        transportasi umum dari pusat Kota Kediri menuju Kecamatan Plosoklaten.
                        Setelah tiba di Plosoklaten, kamu bisa melanjutkan perjalanan menggunakan
                        ojek atau angkutan desa menuju Dusun Kalasan. Perlu diingat bahwa akses
                        transportasi umum menuju Sumber Ubalan terbatas, sehingga disarankan untuk
                        menggunakan kendaraan pribadi atau menyewa kendaraan untuk kenyamanan dan
                        efisiensi waktu.
                    </p>
                </div>
            </div>

            <!-- KOLOM GALERI -->
            <div class="gallery-sidebar">
                <div class="gallery-card">
                    <h2>Galeri Foto</h2>

                    <div class="gallery-photo">
                        <img
                            src="{{ asset('Potensi Desa/Wisata/sumber_ubalan_renang.webp') }}"
                            alt="Kolam renang alami Sumber Ubalan"
                        >
                    </div>

                    <div class="gallery-photo">
                        <img
                            src="{{ asset('Potensi Desa/Wisata/wisata_ubalan_taman.jpg') }}"
                            alt="Taman di sekitar Sumber Ubalan"
                        >
                    </div>

                    <div class="gallery-photo">
                        <img
                            src="{{ asset('Potensi Desa/Wisata/Sumber_Ubalan_Kediri_Permainan.jpg') }}"
                            alt="Wahana permainan di Sumber Ubalan"
                        >
                    </div>

                    <div class="gallery-photo">
                        <img
                            src="{{ asset('Potensi Desa/Wisata/ubalan_kediri_tradisi.jpg') }}"
                            alt="Tradisi dan budaya sekitar Sumber Ubalan"
                        >
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const sidebarEl = document.querySelector('.sidebar');
        document.querySelector('[data-sidebar-toggle]')?.addEventListener('click', () => sidebarEl.classList.toggle('open'));
        document.querySelector('.sidebar-backdrop')?.addEventListener('click', () => sidebarEl.classList.remove('open'));
    </script>
</body>
</html>
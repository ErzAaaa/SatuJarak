<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Pengajuan Permohonan — SatuJarak</title>
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
  --pink-light: #F9C8D7;
  --text: #173D30;
  --muted: #708078;
  --border: #E5ECE8;

  --mint-soft: #DCEFE6;
  --red-dot: #FF4D6D;

  --bg-page: #F7FAF8;
  --card-bg: #FFFFFF;
  --text-main: #1C231F;
  --text-muted: var(--muted);
  --border-soft: var(--border);

  --font-main: "Inter", "Segoe UI", Arial, sans-serif;

  --radius-lg: 24px;
  --radius-md: 14px;
  --radius-sm: 10px;
  --shadow-card: 0 2px 4px rgba(11, 59, 44, 0.04), 0 10px 28px rgba(11, 59, 44, 0.07);
}

* { box-sizing: border-box; }
html, body { height: 100%; }

body {
  margin: 0;
  font-family: var(--font-main);
  background: var(--bg-page);
  color: var(--text-main);
  font-size: 15px;
  line-height: 1.5;
}

a { text-decoration: none; color: inherit; }
button,
input,
select { font-family: inherit; }
button { cursor: pointer; }
h1, h2, h3, h4, h5, h6 { margin: 0; }

.app-shell {
  display: flex;
  min-height: 100vh;
}

.main-content {
  flex: 1;
  min-width: 0;
  display: flex;
  flex-direction: column;
  margin-left: 280px; 
}
.topbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 18px 40px;
  background: var(--card-bg);
  border-bottom: 1px solid var(--border);
}

.topbar-title {
  font-size: 12.5px;
  font-weight: 800;
  letter-spacing: 1.2px;
  color: var(--mint);
}

.topbar-actions { display: flex; align-items: center; gap: 14px; }

.icon-btn {
  width: 46px;
  height: 46px;
  border-radius: 50%;
  border: none;
  background: #EEF4F0;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--forest);
  font-size: 18px;
  position: relative;
  transition: background 0.15s ease;
}
.icon-btn:hover { background: var(--mint-soft); }

.icon-btn .dot {
  position: absolute;
  top: 10px;
  right: 12px;
  width: 9px;
  height: 9px;
  border-radius: 50%;
  background: var(--red-dot);
  border: 2px solid #EEF4F0;
}

.avatar-chip {
  width: 46px;
  height: 46px;
  border-radius: 50%;
  background: var(--mint);
  color: var(--forest);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  border: 3px solid #E4F4EC;
}

.profile-menu { position: relative; }

.profile-chip {
  display: flex;
  align-items: center;
  gap: 8px;
  background: none;
  border: none;
  padding: 0;
  color: var(--muted);
  font-size: 13px;
}

.profile-chip .bi-chevron-down {
  font-size: 13px;
  color: var(--muted);
  transition: transform 0.2s ease;
}
.profile-chip[aria-expanded="true"] .bi-chevron-down { transform: rotate(180deg); }

.profile-dropdown {
  display: none;
  position: absolute;
  top: calc(100% + 12px);
  right: 0;
  width: 260px;
  background: var(--card-bg);
  border-radius: 18px;
  box-shadow: 0 14px 36px rgba(11, 59, 44, 0.16);
  border: 1px solid var(--border);
  padding: 18px;
  z-index: 1200;
}
.profile-dropdown.open { display: block; }

.profile-dropdown-head {
  display: flex;
  align-items: center;
  gap: 12px;
  padding-bottom: 14px;
  margin-bottom: 8px;
  border-bottom: 1px solid var(--border);
}

.profile-dropdown-avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: var(--mint);
  color: var(--forest);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
}

.profile-dropdown-name { font-weight: 800; font-size: 15px; color: var(--text-main); }
.profile-dropdown-role { font-size: 12.5px; color: var(--text-muted); }

.profile-dropdown-list { list-style: none; padding: 0; margin: 0; }

.profile-dropdown-item {
  display: flex;
  align-items: center;
  gap: 10px;
  width: 100%;
  padding: 10px 8px;
  border: none;
  background: none;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  color: var(--text-main);
  text-align: left;
  transition: background 0.15s ease;
}
.profile-dropdown-item i { font-size: 15px; color: var(--muted); width: 18px; }
.profile-dropdown-item:hover { background: var(--mint-soft); }

.topbar-left {
  display: flex;
  align-items: center;
  gap: 12px;
  min-width: 0;
}

.topbar-toggle {
  width: 46px;
  height: 46px;
  border-radius: 50%;
  border: none;
  background: #EEF4F0;
  color: var(--forest);
  font-size: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: background 0.15s ease;
}
.topbar-toggle:hover { background: var(--mint-soft, #DCEFE6); }

.sidebar-backdrop { display: none; }

.page-body {
  padding: 36px 40px;
  flex: 1;
}

.page-heading {
  font-size: 30px;
  font-weight: 800;
  color: var(--forest);
  letter-spacing: -0.3px;
  margin-bottom: 2px;
}

.page-sub {
  color: var(--muted);
  font-size: 14px;
  margin-bottom: 26px;
}
.sidebar {
  width: 280px;
  min-height: 100vh;
  padding: 30px 24px;
  background: var(--forest);
  display: flex;
  flex-direction: column;
  position: fixed;
  left: 0;
  top: 0;
  bottom: 0;
  z-index: 1000;
  overflow-x: hidden;
  overflow-y: auto;
}

.sidebar::before {
  content: "";
  position: absolute;
  width: 230px;
  height: 230px;
  border-radius: 50%;
  background: rgba(112, 198, 155, 0.10);
  left: -110px;
  bottom: 40px;
  pointer-events: none;
}

.sidebar::after {
  content: "";
  position: absolute;
  width: 180px;
  height: 180px;
  border-radius: 50%;
  background: rgba(217, 163, 106, 0.10);
  left: -90px;
  bottom: -50px;
  pointer-events: none;
}

.sidebar > * { position: relative; z-index: 2; }

.brand {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  padding: 0;
  margin-bottom: 38px;
}

.brand-icon {
  width: 82px;
  height: 82px;
  margin: auto;
  border-radius: 25px;
  background: linear-gradient(145deg, var(--gold), var(--mint));
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--forest);
  font-size: 40px;
  box-shadow: 0 12px 25px rgba(0, 0, 0, 0.16);
  flex-shrink: 0;
  animation: logoFloat 4s ease-in-out infinite;
}

.brand-icon img {
  width: 100px;
  height: 100px;
  object-fit: contain;
}

@keyframes logoFloat {
  0%,
  100% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(-5px);
  }
}

@media (prefers-reduced-motion: reduce) {
  .brand-icon { animation: none; }
}

.brand-name {
  color: #FFFFFF;
  font-size: 27px;
  font-weight: 800;
  line-height: 1.2;
  margin: 12px 0 1px;
}

.brand-sub {
  color: #D4E7DF;
  font-size: 12px;
  margin: 0;
}

.nav-list {
  list-style: none;
  padding: 0;
  margin: 0;
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 11px;
}

/* menu berbentuk pil */
.nav-link {
  min-height: 46px;
  padding: 0 18px;
  border-radius: 30px;
  background: rgba(255, 255, 255, 0.96);
  color: var(--text);
  display: flex;
  align-items: center;
  gap: 13px;
  font-size: 15px;
  font-weight: 700;
  transition: all 0.25s ease;
}

.nav-link i { font-size: 17px; }

.nav-link:hover {
  transform: translateX(5px);
  background: var(--mint);
  color: var(--forest);
}

.nav-link.active {
  background: var(--gold);
  color: var(--forest);
  box-shadow: 0 8px 18px rgba(217, 163, 106, 0.22);
}

.nav-link.active::after {
  content: "\F285"; 
  font-family: "bootstrap-icons";
  margin-left: auto;
}

.logout-btn {
  height: 48px;
  padding: 0 16px;
  border: none;
  border-radius: 30px;
  background: var(--mint);
  color: var(--forest);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 14px;
  font-size: 15px;
  font-weight: 700;
  width: 100%;
  transition: 0.25s ease;
}

.logout-btn:hover {
  background: white;
  transform: translateY(-3px);
}

/* ---------- BANTUAN (sidebar) ---------- */
.help-card {
  background: rgba(255, 255, 255, 0.07);
  border: 1px solid rgba(255, 255, 255, 0.14);
  border-radius: 20px;
  padding: 20px 18px;
  margin-top: 18px;
}

.help-title {
  display: flex;
  align-items: center;
  gap: 10px;
  color: #FFFFFF;
  font-weight: 800;
  font-size: 14.5px;
  margin-bottom: 14px;
}

.help-title-icon {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background: linear-gradient(145deg, var(--gold), var(--mint));
  color: var(--forest);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 15px;
  flex-shrink: 0;
}

.help-section-label {
  color: rgba(255, 255, 255, 0.55);
  font-size: 10.5px;
  font-weight: 800;
  letter-spacing: 0.6px;
  text-transform: uppercase;
  margin-bottom: 8px;
}

.help-schedule { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }

.help-schedule-row {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
  gap: 10px;
  font-size: 12.5px;
}

.help-day { color: #FFFFFF; font-weight: 700; }
.help-hours { color: rgba(255, 255, 255, 0.65); font-weight: 600; white-space: nowrap; }

.help-divider {
  height: 1px;
  background: rgba(255, 255, 255, 0.12);
  margin: 14px 0;
  border: none;
}

.help-contact { display: flex; flex-direction: column; gap: 10px; }

.help-contact-link {
  display: flex;
  align-items: center;
  gap: 10px;
  color: #FFFFFF;
  font-size: 12.5px;
  font-weight: 600;
  border-radius: 10px;
  padding: 6px 8px;
  margin: -6px -8px;
  transition: background 0.15s ease;
  word-break: break-all;
}

.help-contact-link:hover { background: rgba(255, 255, 255, 0.08); }

.help-contact-link i {
  width: 26px;
  height: 26px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.10);
  color: var(--mint);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
  flex-shrink: 0;
}

.section-card {
  background: var(--card-bg);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-card);
  border: 1px solid var(--border);
  padding: 28px 32px;
  margin-bottom: 28px;
}

.section-title {
  font-size: 19px;
  font-weight: 800;
  color: var(--forest);
  margin-bottom: 18px;
}

.btn-primary-green {
  background: var(--forest);
  color: #fff;
  border: none;
  border-radius: 999px;
  padding: 12px 30px;
  font-weight: 700;
  font-size: 14.5px;
  transition: background 0.25s ease, transform 0.25s ease;
}

.btn-primary-green:hover {
  background: var(--forest-light);
  color: #fff;
  transform: translateY(-2px);
}

.btn-outline-soft {
  background: #fff;
  color: var(--text);
  border: 1px solid var(--border);
  border-radius: 999px;
  padding: 12px 26px;
  font-weight: 700;
  font-size: 14.5px;
  transition: background 0.25s ease;
}

.btn-outline-soft:hover { background: var(--mint-soft); }

.toast-success {
  position: fixed;
  top: 24px;
  right: 24px;
  background: var(--forest);
  color: #fff;
  padding: 14px 20px;
  border-radius: var(--radius-md);
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 14px;
  font-weight: 600;
  box-shadow: 0 8px 24px rgba(0,0,0,0.18);
  transform: translateY(-12px);
  opacity: 0;
  pointer-events: none;
  transition: all 0.25s ease;
  z-index: 1100;
}

.toast-success.show { transform: translateY(0); opacity: 1; }
.toast-success i { color: var(--mint); font-size: 18px; }

.field-label {
  font-size: 13px;
  font-weight: 700;
  color: var(--text);
  margin-bottom: 6px;
  display: block;
}

.form-control, .form-select {
  border: 1px solid var(--border);
  border-radius: var(--radius-sm);
  padding: 10px 14px;
  font-size: 14.5px;
  background: #F8FAF9;
}

.form-control:focus, .form-select:focus {
  border-color: var(--mint);
  box-shadow: 0 0 0 3px rgba(112, 198, 155, 0.28);
  background: #fff;
}

.field-group { margin-bottom: 18px; }

.upload-box {
  border: 1.5px dashed var(--sage);
  border-radius: var(--radius-md);
  background: #F8FAF9;
  padding: 22px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  flex-wrap: wrap;
}

.upload-box.has-file { border-color: var(--mint); background: var(--mint-soft); }

.upload-hint {
  display: flex;
  align-items: center;
  gap: 12px;
  color: var(--muted);
  font-size: 13.5px;
}

.upload-hint i { font-size: 22px; color: var(--gold); }

.upload-choose-btn {
  background: var(--forest);
  color: #fff;
  border: none;
  border-radius: 999px;
  padding: 9px 20px;
  font-weight: 700;
  font-size: 13.5px;
  flex-shrink: 0;
  cursor: pointer;
  transition: background 0.25s ease;
}

.upload-choose-btn:hover { background: var(--forest-light); }

.invalid-feedback { display: block; }

.status-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 14px;
  border-radius: 999px;
  font-size: 12.5px;
  font-weight: 700;
  letter-spacing: 0.2px;
}
.status-pill.badge-menunggu {
  background: var(--gold-light);
  color: #8C5311;
}
.status-pill.badge-proses {
  background: #E0E7FF;
  color: #3730A3;
}
.status-pill.badge-selesai {
  background: var(--mint-soft);
  color: #0F5132;
}
.status-pill.badge-ditolak {
  background: var(--pink-light);
  color: #842029;
}
.pengajuan-card {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  border-left: 4px solid var(--forest);
}
.pengajuan-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(11, 59, 44, 0.08);
}
.pengajuan-card.status-menunggu { border-left-color: var(--gold); }
.pengajuan-card.status-proses { border-left-color: #6366F1; }
.pengajuan-card.status-selesai { border-left-color: var(--mint); }
.pengajuan-card.status-ditolak { border-left-color: #DC2626; }

@media (max-width: 992px) {
  .main-content { margin-left: 0; }

  .sidebar {
    left: -300px;
    transition: left 0.2s ease;
    box-shadow: 10px 0 30px rgba(0,0,0,0.2);
  }
  .sidebar.open { left: 0; }

  .sidebar.open + .sidebar-backdrop {
    display: block;
    position: fixed;
    inset: 0;
    background: rgba(11, 56, 40, 0.45);
    z-index: 999;
  }

  .page-body { padding: 24px 20px; }
  .topbar { padding: 14px 20px; }
}

@media (max-width: 576px) {
  .sidebar { width: 260px; left: -280px; padding: 24px 18px; }
  .brand { margin-bottom: 28px; }
  .brand-icon { width: 68px; height: 68px; border-radius: 21px; }
  .brand-icon img { width: 83px; height: 83px; }
  .brand-name { font-size: 24px; }
  .help-card { padding: 16px 14px; margin-top: 14px; }

  .page-heading { font-size: 24px; }
  .page-sub { font-size: 13px; }
  .section-card { padding: 20px; border-radius: 20px; }
  .section-title { font-size: 17px; }
  .field-group .row > * { margin-bottom: 12px; }
  .upload-box { padding: 16px; gap: 12px; }
  .upload-choose-btn { padding: 8px 16px; font-size: 13px; }
  .btn-primary-green,
  .btn-outline-soft {
    padding: 11px 22px;
    font-size: 14px;
  }
  .topbar-title { font-size: 11px; }
  .icon-btn, .avatar-chip, .topbar-toggle { width: 40px; height: 40px; }
  .profile-dropdown { width: 230px; right: -8px; }
}
</style>
</head>
<body>

<div class="app-shell">

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
    <li><a href="{{ route('potensi') }}" class="nav-link"><i class="bi bi-stars"></i> Potensi Desa</a></li>
    <li>
      <a href="{{ route('pengajuan.index', ['action' => 'list']) }}" class="nav-link {{ $action === 'list' ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Riwayat Pengajuan
        @if(isset($pengajuans) && $pengajuans->count() > 0)
          <span class="badge rounded-pill bg-light text-dark ms-auto" style="font-size: 11px;">{{ $pengajuans->count() }}</span>
        @endif
      </a>
    </li>
    <li>
      <a href="{{ route('pengajuan.index', ['action' => 'create']) }}" class="nav-link {{ $action === 'create' ? 'active' : '' }}">
        <i class="bi bi-plus-circle-fill"></i> Buat Pengajuan
      </a>
    </li>
  </ul>

  <div class="help-card">
    <div class="help-title">
      <span class="help-title-icon"><i class="bi bi-headset"></i></span>
      Butuh Bantuan?
    </div>

    <div class="help-section-label">Jam Operasional Kantor Desa</div>
    <div class="help-schedule">
      <div class="help-schedule-row">
        <span class="help-day">Senin - Kamis</span>
        <span class="help-hours">08.00 - 13.00 WIB</span>
      </div>
      <div class="help-schedule-row">
        <span class="help-day">Jumat</span>
        <span class="help-hours">08.00 - 11.00 WIB</span>
      </div>
    </div>

    <hr class="help-divider">

    <div class="help-contact">
      <a href="mailto:desajarak204@gmail.com" class="help-contact-link">
        <i class="bi bi-envelope-fill"></i> desajarak204@gmail.com
      </a>
      <a href="https://instagram.com/ds.jarak" target="_blank" rel="noopener" class="help-contact-link">
        <i class="bi bi-instagram"></i> @ds.jarak
      </a>
    </div>
  </div>
</aside>
  <div class="sidebar-backdrop" data-sidebar-backdrop></div>

  <div class="main-content">
    <div class="topbar">
      <div class="topbar-left">
        <button class="topbar-toggle d-lg-none" data-sidebar-toggle aria-label="Buka menu"><i class="bi bi-list"></i></button>
        <div class="topbar-title">USER · PENGAJUAN PERMOHONAN</div>
      </div>
      <div class="topbar-actions">
        <button class="icon-btn"><i class="bi bi-bell-fill"></i><span class="dot"></span></button>

        <div class="profile-menu">
          <button class="profile-chip" type="button" data-profile-toggle aria-haspopup="true" aria-expanded="false">
            <div class="avatar-chip"><i class="bi bi-person-fill"></i></div>
            <i class="bi bi-chevron-down"></i>
          </button>

          <div class="profile-dropdown" data-profile-dropdown>
            <div class="profile-dropdown-head">
              <span class="profile-dropdown-avatar"><i class="bi bi-person-fill"></i></span>
              <div>
                <div class="profile-dropdown-name">{{ Auth::user()->name ?? 'User' }}</div>
                <div class="profile-dropdown-role">Mahasiswa</div>
              </div>
            </div>
            <ul class="profile-dropdown-list">
              <li><a href="#" onclick="return false;" class="profile-dropdown-item"><i class="bi bi-person"></i> Profil</a></li>
              <li><a href="#" onclick="return false;" class="profile-dropdown-item"><i class="bi bi-gear"></i> Pengaturan</a></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="profile-dropdown-item"><i class="bi bi-box-arrow-right"></i> Log Out</button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="page-body">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
          <h1 class="page-heading">
            {{ $action === 'list' ? 'Riwayat Pengajuan Saya' : 'Pengajuan Permohonan Baru' }}
          </h1>
          <p class="page-sub">
            {{ $action === 'list' ? 'Pantau perkembangan dan status surat atau permohonan yang telah Anda ajukan.' : 'Isi data di bawah ini dengan lengkap untuk mengajukan kegiatan KKN/Riset di desa.' }}
          </p>
        </div>
        <div class="d-flex align-items-center gap-2">
          @if ($action === 'list')
            <a href="{{ route('pengajuan.index', ['action' => 'create']) }}" class="btn-primary-green d-inline-flex align-items-center gap-2 text-decoration-none">
              <i class="bi bi-plus-lg"></i> Buat Pengajuan Baru
            </a>
          @else
            @if (isset($pengajuans) && $pengajuans->isNotEmpty())
              <a href="{{ route('pengajuan.index', ['action' => 'list']) }}" class="btn-outline-soft d-inline-flex align-items-center gap-2 text-decoration-none">
                <i class="bi bi-clock-history"></i> Riwayat Pengajuan ({{ $pengajuans->count() }})
              </a>
            @endif
          @endif
        </div>
      </div>

      @if (session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4" style="border-radius: var(--radius-sm); font-size: 14px;" role="alert">
          <i class="bi bi-check-circle-fill fs-5"></i>
          <div>{{ session('success') }}</div>
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger mb-4" style="border-radius: var(--radius-sm); font-size: 14px;" role="alert">
          <div class="d-flex align-items-center gap-2 mb-1 fw-bold">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <span>Pengajuan gagal dikirim. Periksa kesalahan berikut:</span>
          </div>
          <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if ($action === 'list')
        @if ($pengajuans->isEmpty())
          <div class="section-card text-center py-5">
            <div class="mb-3">
              <div style="width: 84px; height: 84px; background: var(--mint-soft); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: var(--forest); font-size: 38px;">
                <i class="bi bi-file-earmark-text"></i>
              </div>
            </div>
            <h3 style="font-weight: 800; color: var(--forest); margin-bottom: 8px;">Belum Ada Pengajuan</h3>
            <p style="color: var(--muted); max-width: 480px; margin: 0 auto 24px; font-size: 14.5px;">
              Anda belum memiliki riwayat pengajuan kegiatan KKN atau Riset di Desa Jarak. Silakan buat pengajuan pertama Anda dengan menekan tombol di bawah.
            </p>
            <a href="{{ route('pengajuan.index', ['action' => 'create']) }}" class="btn-primary-green d-inline-flex align-items-center gap-2 text-decoration-none">
              <i class="bi bi-plus-circle-fill"></i> Buat Pengajuan Sekarang
            </a>
          </div>
        @else
          <div class="d-flex flex-column gap-3">
            @foreach ($pengajuans as $p)
              @php
                $kode = 'PGJ-' . str_pad($p->id, 3, '0', STR_PAD_LEFT);
                $badgeClass = match($p->status) {
                  'Menunggu Verifikasi' => 'badge-menunggu',
                  'Sedang Diproses' => 'badge-proses',
                  'Selesai' => 'badge-selesai',
                  'Ditolak' => 'badge-ditolak',
                  default => 'badge-menunggu',
                };
                $badgeIcon = match($p->status) {
                  'Menunggu Verifikasi' => 'bi-hourglass-split',
                  'Sedang Diproses' => 'bi-arrow-repeat',
                  'Selesai' => 'bi-check-circle-fill',
                  'Ditolak' => 'bi-x-circle-fill',
                  default => 'bi-clock-fill',
                };
                $cardStatus = match($p->status) {
                  'Menunggu Verifikasi' => 'status-menunggu',
                  'Sedang Diproses' => 'status-proses',
                  'Selesai' => 'status-selesai',
                  'Ditolak' => 'status-ditolak',
                  default => 'status-menunggu',
                };
              @endphp
              <div class="section-card pengajuan-card {{ $cardStatus }} mb-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 mb-3 border-bottom">
                  <div class="d-flex align-items-center gap-2">
                    <span style="font-weight: 800; color: var(--forest); font-size: 16px;">#{{ $kode }}</span>
                    <span class="text-muted">•</span>
                    <span class="text-muted" style="font-size: 13.5px;">
                      <i class="bi bi-calendar3 me-1"></i>
                      {{ $p->created_at ? $p->created_at->translatedFormat('d F Y, H:i') : '-' }} WIB
                    </span>
                  </div>
                  <div>
                    <span class="status-pill {{ $badgeClass }}">
                      <i class="bi {{ $badgeIcon }}"></i> {{ $p->status }}
                    </span>
                  </div>
                </div>

                <div class="row align-items-center gy-3">
                  <div class="col-lg-8">
                    <h4 style="font-weight: 800; color: var(--forest); font-size: 18px; margin-bottom: 8px;">
                      {{ $p->judul_kerjasama ?? $p->jenis_kegiatan ?? 'Permohonan Kerjasama Kegiatan' }}
                    </h4>
                    <div class="d-flex flex-wrap gap-x-4 gap-y-2 mb-2" style="font-size: 13.5px; color: var(--text-main);">
                      <div><span class="text-muted">Instansi:</span> <strong>{{ $p->nama_instansi ?? $p->universitas ?? '-' }}</strong></div>
                      <div><span class="text-muted">Pemohon:</span> <strong>{{ $p->nama_lengkap }}</strong></div>
                      @if($p->fakultas)
                        <div><span class="text-muted">Fakultas:</span> <strong>{{ $p->fakultas }}</strong></div>
                      @endif
                    </div>
                    @if ($p->catatan_admin)
                      <div class="mt-2 p-2 px-3 rounded" style="background: #FFFBEB; border: 1px solid #FDE68A; font-size: 13px; color: #92400E;">
                        <strong>Catatan Petugas:</strong> {{ $p->catatan_admin }}
                      </div>
                    @endif
                  </div>
                  <div class="col-lg-4 text-lg-end d-flex flex-column flex-sm-row justify-content-lg-end gap-2">
                    @if ($p->status === 'Selesai')
                      <a href="{{ route('admin.pengajuan.surat', $p->id) }}" target="_blank" class="btn-outline-soft d-inline-flex align-items-center justify-content-center gap-2 text-decoration-none" style="padding: 10px 18px; font-size: 13.5px;">
                        <i class="bi bi-file-earmark-check-fill text-success"></i> Surat
                      </a>
                    @endif
                    <a href="{{ route('pengajuan.show', $p->id) }}" class="btn-primary-green d-inline-flex align-items-center justify-content-center gap-2 text-decoration-none" style="padding: 10px 22px; font-size: 13.5px;">
                      <i class="bi bi-eye-fill"></i> Lihat Detail
                    </a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      @else
        <form id="form-pengajuan" novalidate method="POST" action="{{ route('pengajuan.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="section-card">
          <div class="section-title">Data Pemohon</div>
          <div class="row">
            <div class="col-12 field-group">
              <label class="field-label">Nama Lengkap</label>
              <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
              @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 field-group">
              <label class="field-label">NIM</label>
              <input type="text" class="form-control @error('nim') is-invalid @enderror" name="nim" value="{{ old('nim') }}" required>
              @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 field-group">
              <label class="field-label">Universitas</label>
              <input type="text" class="form-control @error('universitas') is-invalid @enderror" name="universitas" value="{{ old('universitas') }}" required>
              @error('universitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 field-group">
              <label class="field-label">Fakultas/Jurusan</label>
              <input type="text" class="form-control @error('fakultas') is-invalid @enderror" name="fakultas" value="{{ old('fakultas') }}" required>
              @error('fakultas') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 field-group">
              <label class="field-label">No Hp</label>
              <input type="tel" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}" required>
              @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 field-group mb-0">
              <label class="field-label">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="section-title">Detail Kegiatan</div>
          <div class="row">
            <div class="col-12 field-group">
              <label class="field-label">Jenis Permohonan</label>
              <select class="form-select @error('jenis_permohonan') is-invalid @enderror" name="jenis_permohonan" required>
                <option value="" {{ old('jenis_permohonan') ? '' : 'selected' }} disabled>Pilih jenis permohonan</option>
                <option value="kkn" {{ old('jenis_permohonan') == 'kkn' ? 'selected' : '' }}>KKN</option>
                <option value="riset" {{ old('jenis_permohonan') == 'riset' ? 'selected' : '' }}>Riset</option>
              </select>
              @error('jenis_permohonan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 field-group">
              <label class="field-label">Judul Kegiatan</label>
              <input type="text" class="form-control @error('judul_kegiatan') is-invalid @enderror" name="judul_kegiatan" value="{{ old('judul_kegiatan') }}" required>
              @error('judul_kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 field-group">
              <label class="field-label">Lokasi Spesifik</label>
              <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" value="{{ old('lokasi') }}" required>
              @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 field-group">
              <label class="field-label">Jumlah Peserta</label>
              <input type="number" min="1" class="form-control @error('jumlah_peserta') is-invalid @enderror" name="jumlah_peserta" value="{{ old('jumlah_peserta') }}" required>
              @error('jumlah_peserta') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 field-group">
              <label class="field-label">Tanggal Mulai</label>
              <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
              @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 field-group">
              <label class="field-label">Tanggal Selesai</label>
              <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
              @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 field-group mb-0">
              <label class="field-label">Dosen Pembimbing</label>
              <input type="text" class="form-control @error('dosen_pembimbing') is-invalid @enderror" name="dosen_pembimbing" value="{{ old('dosen_pembimbing') }}" required>
              @error('dosen_pembimbing') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="section-title">Upload Berkas</div>
          <label class="field-label">Proposal Kegiatan</label>
          <div class="upload-box" id="upload-box">
            <div class="upload-hint">
              <i class="bi bi-cloud-arrow-up-fill"></i>
              <div>
                <div id="upload-filename" style="font-weight:600; color:var(--text-main);">Belum ada file dipilih</div>
                <div>Format PDF, maks. 5MB</div>
              </div>
            </div>
            <label class="upload-choose-btn" for="proposal-file">Pilih File</label>
            <input type="file" id="proposal-file" name="file_proposal" accept=".pdf" hidden required>
          </div>
          @error('file_proposal') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
          <a href="{{ route('pengajuan.index', ['action' => 'list']) }}" class="btn-outline-soft text-decoration-none">Batal</a>
          <button type="submit" class="btn-primary-green">Kirim Pengajuan</button>
        </div>
      </form>
      @endif
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function initSidebarToggle() {
  const toggleBtn = document.querySelector('[data-sidebar-toggle]');
  const backdrop = document.querySelector('[data-sidebar-backdrop]');
  const sidebar = document.querySelector('.sidebar');
  if (!toggleBtn || !sidebar) return;

  toggleBtn.addEventListener('click', () => sidebar.classList.toggle('open'));
  if (backdrop) backdrop.addEventListener('click', () => sidebar.classList.remove('open'));
}

function initProfileDropdown() {
  const toggleBtn = document.querySelector('[data-profile-toggle]');
  const dropdown = document.querySelector('[data-profile-dropdown]');
  if (!toggleBtn || !dropdown) return;

  const closeDropdown = () => {
    dropdown.classList.remove('open');
    toggleBtn.setAttribute('aria-expanded', 'false');
  };

  toggleBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    const isOpen = dropdown.classList.toggle('open');
    toggleBtn.setAttribute('aria-expanded', String(isOpen));
  });

  document.addEventListener('click', (e) => {
    if (!dropdown.contains(e.target) && !toggleBtn.contains(e.target)) closeDropdown();
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeDropdown();
  });
}

function initPengajuanForm() {
  const form = document.getElementById('form-pengajuan');
  if (!form) return;

  const fileInput = document.getElementById('proposal-file');
  const uploadBox = document.getElementById('upload-box');
  const uploadText = document.getElementById('upload-filename');

  fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) {
      uploadText.textContent = fileInput.files[0].name;
      uploadBox.classList.add('has-file');
    } else {
      uploadText.textContent = 'Belum ada file dipilih';
      uploadBox.classList.remove('has-file');
    }
  });

  form.addEventListener('submit', (e) => {
    if (!form.checkValidity()) {
      e.preventDefault();
      form.classList.add('was-validated');
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  initSidebarToggle();
  initProfileDropdown();
  initPengajuanForm();
});
</script>
</body>
</html>
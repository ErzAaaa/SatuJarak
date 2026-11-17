<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPotensiDesaController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\UmkmController;
use Illuminate\Support\Facades\Route;

// ---------- Publik ----------
Route::view('/', 'welcome')->name('home');
Route::redirect('/layanan', '/#layanan')->name('layanan');
Route::view('/potensi', 'User.potensiDesa')->name('potensi');
Route::view('/potensi-desa', 'User.potensiDesa')->name('potensi-desa');
Route::view('/potensi-desa/wisata', 'User.wisata')->name('wisata.index');
Route::get('/potensi-desa/produk', [UmkmController::class, 'index'])->name('laman-umkm');
Route::get('/potensi-desa/produk/{slug}', [UmkmController::class, 'show'])->name('detail-produk');
Route::redirect('/potensi-desa/umkm', '/potensi-desa/produk');

// ---------- Auth user (tamu saja) ----------
Route::view('/login', 'auth.login')->name('login');
Route::view('/daftar', 'auth.daftar')->name('daftar');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.submit');
Route::post('/daftar', [UserAuthController::class, 'register'])->name('daftar.submit');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

// ---------- Login admin ----------
// URL disembunyikan via .env — tidak terdaftar secara publik.
// Percobaan login gagal dibatasi berdasarkan email + IP di controller.
$secretPath = env('ADMIN_SECRET_LOGIN_PATH', 'portal-desa-rahasia-2026');
Route::get($secretPath, [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
Route::post($secretPath, [AdminLoginController::class, 'login'])
    ->name('admin.login.submit');

// ---------- Pengajuan (wajib login sebagai user) ----------
Route::middleware('auth')->group(function () {
    Route::get('/userpengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/detailpengajuan/{pengajuan}', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
});

// ---------- Admin (wajib login + is_admin) ----------
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Pengajuan
    Route::get('/pengajuan', [PengajuanController::class, 'adminIndex'])->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', [PengajuanController::class, 'adminShow'])->name('pengajuan.show');
    Route::patch('/pengajuan/{pengajuan}', [PengajuanController::class, 'adminUpdate'])->name('pengajuan.update');
    Route::get('/pengajuan/{pengajuan}/surat-persetujuan', [PengajuanController::class, 'suratPersetujuan'])->name('pengajuan.surat');

    // Kelola Pengguna (User Management & Real-time Tracking)
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/detail', [AdminUserController::class, 'showSelf'])->name('users.detail');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Kelola Potensi Desa / UMKM (CRUD Dinamis)
    Route::get('/potensi-desa', [AdminPotensiDesaController::class, 'index'])->name('potensi.index');
    Route::post('/potensi-desa', [AdminPotensiDesaController::class, 'store'])->name('potensi.store');
    Route::get('/potensi-desa/detail', [AdminPotensiDesaController::class, 'index'])->name('potensi.detail');
    Route::get('/potensi-desa/{potensi}', [AdminPotensiDesaController::class, 'show'])->name('potensi.show');
    Route::put('/potensi-desa/{potensi}', [AdminPotensiDesaController::class, 'update'])->name('potensi.update');
    Route::delete('/potensi-desa/{potensi}', [AdminPotensiDesaController::class, 'destroy'])->name('potensi.destroy');

    // Halaman statis admin (layanan)
    Route::view('/layanan', 'Admin.manageLayanan')->name('layanan.index');
    Route::view('/layanan/detail', 'Admin.detailLayanan')->name('layanan.detail');
    Route::view('/pengajuan/detail', 'Admin.detailPengajuan')->name('pengajuan.detail');

    // Alias lama (dipertahankan agar link tim tidak putus, kini di dalam group middleware)
    Route::get('/adminUserTable', [AdminUserController::class, 'index'])->name('adminUserTable');
    Route::get('/adminUserDetail', [AdminUserController::class, 'showSelf'])->name('adminUserDetail');

    // Redirect fallback jika ada link statis .html lama yang terpanggil
    Route::redirect('/managePengajuan.html', '/admin/pengajuan');
    Route::redirect('/manageLayanan.html', '/admin/layanan');
    Route::redirect('/detailPengajuan.html', '/admin/pengajuan');
    Route::redirect('/admin_user_table.html', '/admin/users');
    Route::redirect('/dashboardadmin.html', '/admin/dashboard');
});

// ---------- Fallback dan alias lama di luar prefix /admin ----------
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.legacy');
    Route::get('/dashboardadmin', [AdminDashboardController::class, 'index']);
    Route::redirect('/managePengajuan.html', '/admin/pengajuan');
    Route::redirect('/manageLayanan.html', '/admin/layanan');
    Route::redirect('/detailPengajuan.html', '/admin/pengajuan');
    Route::redirect('/admin_user_table.html', '/admin/users');
    Route::redirect('/dashboardadmin.html', '/admin/dashboard');
});

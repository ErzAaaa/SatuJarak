# 📦 Database SatuJarak — Panduan Setup Supabase

> Panduan ini khusus untuk setup database dari sisi **User** (masyarakat/mahasiswa pemohon).
> Jalankan SQL di bawah ini secara manual di **Supabase SQL Editor** sesuai urutan.

---

## ⚠️ Penting Sebelum Mulai

- Supabase sudah terkoneksi lewat file `.env` (lihat `DB_HOST`, `DB_DATABASE`, dll.)
- **Jangan** jalankan `php artisan migrate` di lokal untuk tabel ini karena sudah diarahkan ke Supabase langsung.
- Jalankan SQL di bawah ini satu per satu secara berurutan di **Supabase > SQL Editor**.
- Jika tabel sudah ada, skip bagian yang sudah ada (cek dulu via **Table Editor** di Supabase).

---

## 🗂️ Daftar Tabel yang Dibutuhkan (Sisi User)

```
1. users                  → Akun pemohon (mahasiswa/masyarakat)
2. password_reset_tokens  → Reset password (bawaan Laravel)
3. sessions               → Sesi login aktif (bawaan Laravel)
4. cache                  → Cache aplikasi (bawaan Laravel)
5. cache_locks            → Lock mekanisme cache
6. jobs                   → Queue/antrian job (bawaan Laravel)
7. job_batches            → Batch job
8. failed_jobs            → Log job yang gagal
9. pengajuans             → Data pengajuan KKN/Riset oleh user
```

---

## 📋 Diagram Relasi (ERD Sederhana)

```
users ──────────────────── pengajuans
  id (PK)                    id (PK)
  name                       user_id (FK → users.id, nullable)
  email (UNIQUE)             nama_lengkap
  password                   nim
  is_admin                   email_pemohon
  ...                        no_hp
                             nama_instansi
                             jenis_kegiatan
                             judul_kerjasama
                             tanggal_mulai
                             tanggal_selesai
                             deskripsi
                             file_proposal (path)
                             file_surat (path)
                             status (enum)
                             catatan_admin
                             ...
```

---

## 🚨 Ketidaksesuaian: Form vs Migrasi (Perlu Didiskusikan Tim)

> Form di `userpengajuan.blade.php` memiliki **beberapa field tambahan** yang belum ada di migrasi database saat ini. Kolom-kolom berikut ada di form tapi **belum ada di tabel `pengajuans`**:

| Field di Form (View)       | Status di DB         | Keterangan                              |
|---------------------------|----------------------|-----------------------------------------|
| `universitas`             | ❌ Belum ada          | Nama universitas pemohon                |
| `fakultas`                | ❌ Belum ada          | Jurusan/fakultas pemohon                |
| `lokasi`                  | ❌ Belum ada          | Lokasi spesifik kegiatan                |
| `jumlah_peserta`          | ❌ Belum ada          | Jumlah anggota KKN/Riset                |
| `dosen_pembimbing`        | ❌ Belum ada          | Nama dosen pembimbing                   |
| `jenis_permohonan`        | ⚠️ Beda nama         | Di DB namanya `jenis_kegiatan`         |
| `judul_kegiatan`          | ⚠️ Beda nama         | Di DB namanya `judul_kerjasama`        |
| `email` (di form)         | ⚠️ Beda nama         | Di DB namanya `email_pemohon`          |

**Rekomendasi:** Sesuaikan migrasi dengan menambahkan kolom yang kurang, atau update form agar nama field-nya konsisten dengan kolom database. Perlu diputuskan bersama tim.

---

## 🛠️ SQL Setup — Jalankan di Supabase SQL Editor

### LANGKAH 1 — Tabel `users`

```sql
CREATE TABLE IF NOT EXISTS users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMPTZ NULL,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT FALSE,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMPTZ NULL,
    updated_at TIMESTAMPTZ NULL
);

COMMENT ON TABLE users IS 'Akun pemohon (mahasiswa/masyarakat) dan admin desa';
COMMENT ON COLUMN users.is_admin IS 'TRUE = admin desa, FALSE = pemohon biasa';
```

---

### LANGKAH 2 — Tabel `password_reset_tokens`

```sql
CREATE TABLE IF NOT EXISTS password_reset_tokens (
    email VARCHAR(255) NOT NULL PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMPTZ NULL
);
```

---

### LANGKAH 3 — Tabel `sessions`

```sql
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id BIGINT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);

CREATE INDEX IF NOT EXISTS sessions_user_id_index ON sessions (user_id);
CREATE INDEX IF NOT EXISTS sessions_last_activity_index ON sessions (last_activity);
```

---

### LANGKAH 4 — Tabel `cache` dan `cache_locks`

```sql
CREATE TABLE IF NOT EXISTS cache (
    key VARCHAR(255) NOT NULL PRIMARY KEY,
    value TEXT NOT NULL,
    expiration BIGINT NOT NULL
);

CREATE INDEX IF NOT EXISTS cache_expiration_index ON cache (expiration);

CREATE TABLE IF NOT EXISTS cache_locks (
    key VARCHAR(255) NOT NULL PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration BIGINT NOT NULL
);

CREATE INDEX IF NOT EXISTS cache_locks_expiration_index ON cache_locks (expiration);
```

---

### LANGKAH 5 — Tabel `jobs`, `job_batches`, `failed_jobs`

```sql
CREATE TABLE IF NOT EXISTS jobs (
    id BIGSERIAL PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload TEXT NOT NULL,
    attempts SMALLINT NOT NULL,
    reserved_at INTEGER NULL,
    available_at INTEGER NOT NULL,
    created_at INTEGER NOT NULL
);

CREATE INDEX IF NOT EXISTS jobs_queue_index ON jobs (queue);

CREATE TABLE IF NOT EXISTS job_batches (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INTEGER NOT NULL,
    pending_jobs INTEGER NOT NULL,
    failed_jobs INTEGER NOT NULL,
    failed_job_ids TEXT NOT NULL,
    options TEXT NULL,
    cancelled_at INTEGER NULL,
    created_at INTEGER NOT NULL,
    finished_at INTEGER NULL
);

CREATE TABLE IF NOT EXISTS failed_jobs (
    id BIGSERIAL PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload TEXT NOT NULL,
    exception TEXT NOT NULL,
    failed_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS failed_jobs_connection_queue_failed_at_index
    ON failed_jobs (connection, queue, failed_at);
```

---

### LANGKAH 6 — Tabel `pengajuans` (Inti — Data Pengajuan User)

> ⚠️ SQL ini berdasarkan **migrasi yang sudah ada**. Sebelum jalankan, diskusikan dulu dengan tim apakah kolom tambahan dari form (`universitas`, `fakultas`, `lokasi`, dll.) perlu ditambahkan.

```sql
CREATE TYPE pengajuan_status AS ENUM (
    'Menunggu Verifikasi',
    'Sedang Diproses',
    'Selesai',
    'Ditolak'
);

CREATE TABLE IF NOT EXISTS pengajuans (
    id BIGSERIAL PRIMARY KEY,

    -- Relasi ke user (nullable: jika user dihapus, pengajuan tetap ada)
    user_id BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,

    -- Data pemohon
    nama_lengkap VARCHAR(255) NOT NULL,
    nim VARCHAR(20) NULL,
    email_pemohon VARCHAR(255) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    program_studi VARCHAR(100) NULL,

    -- Data institusi/kegiatan
    nama_instansi VARCHAR(255) NOT NULL,
    jenis_kegiatan VARCHAR(100) NOT NULL,
    judul_kerjasama VARCHAR(200) NOT NULL,
    tanggal_mulai DATE NULL,
    tanggal_selesai DATE NULL,
    deskripsi TEXT NULL,

    -- Dokumen (path file di storage)
    file_proposal VARCHAR(255) NULL,
    file_surat VARCHAR(255) NULL,

    -- Status alur
    status pengajuan_status NOT NULL DEFAULT 'Menunggu Verifikasi',
    catatan_admin TEXT NULL,

    created_at TIMESTAMPTZ NULL,
    updated_at TIMESTAMPTZ NULL
);

CREATE INDEX IF NOT EXISTS pengajuans_user_id_index ON pengajuans (user_id);
CREATE INDEX IF NOT EXISTS pengajuans_status_index ON pengajuans (status);

COMMENT ON TABLE pengajuans IS 'Data pengajuan KKN/Riset oleh mahasiswa/masyarakat';
COMMENT ON COLUMN pengajuans.file_proposal IS 'Path relatif di storage/app/public/pengajuan/proposal/';
COMMENT ON COLUMN pengajuans.file_surat IS 'Path relatif di storage/app/public/pengajuan/surat/';
```

---

### (OPSIONAL) Kolom Tambahan dari Form — Tambahkan Jika Disepakati Tim

Jika tim memutuskan untuk menyesuaikan database mengikuti form yang ada:

```sql
ALTER TABLE pengajuans
    ADD COLUMN IF NOT EXISTS universitas VARCHAR(255) NULL,
    ADD COLUMN IF NOT EXISTS fakultas VARCHAR(255) NULL,
    ADD COLUMN IF NOT EXISTS lokasi VARCHAR(255) NULL,
    ADD COLUMN IF NOT EXISTS jumlah_peserta INTEGER NULL,
    ADD COLUMN IF NOT EXISTS dosen_pembimbing VARCHAR(255) NULL;

COMMENT ON COLUMN pengajuans.universitas IS 'Nama universitas pemohon';
COMMENT ON COLUMN pengajuans.lokasi IS 'Lokasi spesifik kegiatan di desa';
COMMENT ON COLUMN pengajuans.jumlah_peserta IS 'Jumlah anggota tim KKN/Riset';
COMMENT ON COLUMN pengajuans.dosen_pembimbing IS 'Nama dosen pembimbing kegiatan';
```

---

## ✅ Verifikasi Setelah Input SQL

Setelah semua SQL dijalankan, cek di **Supabase > Table Editor** bahwa tabel-tabel ini sudah ada:

- [ ] `users`
- [ ] `password_reset_tokens`
- [ ] `sessions`
- [ ] `cache`
- [ ] `cache_locks`
- [ ] `jobs`
- [ ] `job_batches`
- [ ] `failed_jobs`
- [ ] `pengajuans`

Kemudian coba jalankan aplikasi dan daftar akun baru. Jika berhasil, database sudah berjalan dengan benar.

---

## 🧪 Setelah Database Siap — Buat Akun Admin

Jalankan perintah ini di terminal untuk membuat akun admin:

```bash
php artisan db:seed
```

> **Catatan:** Jangan buat akun admin langsung di Supabase karena password tidak akan ter-hash. Gunakan `php artisan db:seed` agar password otomatis di-hash dengan benar oleh Laravel.

---

*File ini dibuat untuk keperluan dokumentasi internal proyek SatuJarak.*
*Jangan commit kredensial atau data sensitif ke repository.*


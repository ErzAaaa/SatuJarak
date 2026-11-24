<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;

class Pengajuan extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nim',
        'universitas',
        'fakultas',
        'email_pemohon',
        'no_hp',
        'program_studi',
        'nama_instansi',
        'jenis_kegiatan',
        'judul_kerjasama',
        'lokasi',
        'jumlah_peserta',
        'tanggal_mulai',
        'tanggal_selesai',
        'dosen_pembimbing',
        'deskripsi',
        'file_proposal',
        'file_surat',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // ── Relasi ──────────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes helper ───────────────────────────────────────
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'Menunggu Verifikasi');
    }

    public function scopeProses($query)
    {
        return $query->where('status', 'Sedang Diproses');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'Selesai');
    }

    // ── Accessors & Helper Storage Aman (S3 + Fallback Lokal) ─
    public static function isS3Configured(): bool
    {
        return class_exists(AwsS3V3Adapter::class)
            && filled(config('filesystems.disks.s3.key'))
            && filled(config('filesystems.disks.s3.secret'))
            && filled(config('filesystems.disks.s3.bucket'));
    }

    public static function uploadDisk(): string
    {
        return self::isS3Configured() ? 's3' : 'public';
    }

    public function getProposalUrlAttribute(): ?string
    {
        return self::resolveFileUrl($this->file_proposal);
    }

    public function getSuratUrlAttribute(): ?string
    {
        return self::resolveFileUrl($this->file_surat);
    }

    private static function resolveFileUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (file_exists(public_path('storage/'.$path))) {
            return asset('storage/'.$path);
        }

        if (self::isS3Configured()) {
            try {
                return Storage::disk('s3')->url($path);
            } catch (\Throwable) {
                // Fallback ke storage lokal jika URL S3 gagal dibentuk
            }
        }

        return asset('storage/'.$path);
    }
}

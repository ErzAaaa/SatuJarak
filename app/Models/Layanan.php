<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_layanan',
        'nama_layanan',
        'kategori',
        'deskripsi',
        'link_url',
        'logo',
        'status',
        'urutan',
    ];

    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    /**
     * Susun ulang seluruh nomor urut dan kode layanan secara rapat dan berurutan:
     * LYN-001, LYN-002, LYN-003, ...
     */
    public static function reorderSequences(): void
    {
        DB::transaction(function () {
            $layanans = static::query()->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();

            // 1. Temporary code to avoid PostgreSQL unique constraint collisions
            foreach ($layanans as $index => $item) {
                $seq = $index + 1;
                $item->updateQuietly([
                    'urutan' => $seq,
                    'kode_layanan' => 'TEMP-'.$item->id.'-'.$seq,
                ]);
            }

            // 2. Set clean sequential codes: LYN-001, LYN-002, ...
            foreach ($layanans as $index => $item) {
                $seq = $index + 1;
                $item->updateQuietly([
                    'urutan' => $seq,
                    'kode_layanan' => 'LYN-'.str_pad($seq, 3, '0', STR_PAD_LEFT),
                ]);
            }
        });
    }

    public function getLogoUrlAttribute(): string
    {
        $raw = $this->logo;
        if (empty($raw)) {
            return asset('images/logo.png');
        }

        if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
            return $raw;
        }

        // Cek path langsung di public/
        if (file_exists(public_path($raw))) {
            return asset($raw);
        }

        // Cek jika di database ada spasi namun file di disk memakai underscore
        $withUnderscore = str_replace(' ', '_', $raw);
        if (file_exists(public_path($withUnderscore))) {
            return asset($withUnderscore);
        }

        // Cek di folder public/storage/
        if (file_exists(public_path('storage/'.$raw))) {
            return asset('storage/'.$raw);
        }
        if (file_exists(public_path('storage/'.$withUnderscore))) {
            return asset('storage/'.$withUnderscore);
        }

        return asset('images/logo.png');
    }
}

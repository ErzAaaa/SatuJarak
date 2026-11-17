<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PotensiDesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'kategori',
        'jenis_produk',
        'pemilik',
        'lokasi',
        'kontak',
        'whatsapp',
        'sosmed',
        'foto',
        'foto_2',
        'foto_3',
        'deskripsi',
        'harga_teks',
        'harga_mulai',
        'harga_sampai',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'harga_mulai' => 'decimal:0',
        'harga_sampai' => 'decimal:0',
    ];

    protected static function booted(): void
    {
        static::saving(function (PotensiDesa $model) {
            if (empty($model->slug) && ! empty($model->nama)) {
                $model->slug = Str::slug($model->nama);
            }

            if (empty($model->whatsapp) && ! empty($model->kontak)) {
                $clean = preg_replace('/[^0-9]/', '', $model->kontak);
                if (str_starts_with($clean, '0')) {
                    $clean = '62'.substr($clean, 1);
                }
                $model->whatsapp = $clean;
            }
        });
    }

    // ── Scopes ──────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    public function scopeUmkm($query)
    {
        return $query->where('kategori', 'UMKM');
    }

    public function scopeKuliner($query)
    {
        return $query->where(function ($q) {
            $q->where('jenis_produk', 'Kuliner')
                ->orWhere('jenis_produk', 'Makanan')
                ->orWhere('jenis_produk', 'Minuman');
        });
    }

    public function scopeKerajinan($query)
    {
        return $query->where('jenis_produk', 'Kerajinan');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // ── Accessors ───────────────────────────────────────

    /**
     * Format tampilan harga untuk kartu / halaman detail.
     */
    public function getHargaFormattedAttribute(): string
    {
        if (! empty($this->harga_teks)) {
            return $this->harga_teks;
        }

        if ($this->harga_mulai && $this->harga_sampai) {
            return 'Rp '.number_format($this->harga_mulai, 0, ',', '.').' - Rp '.number_format($this->harga_sampai, 0, ',', '.');
        }

        if ($this->harga_mulai) {
            return 'Rp '.number_format($this->harga_mulai, 0, ',', '.');
        }

        return 'Hubungi Penjual';
    }

    /**
     * Link langsung chat WhatsApp ke pemilik UMKM.
     */
    public function getWhatsappUrlAttribute(): ?string
    {
        $nomor = $this->whatsapp;
        if (empty($nomor) && ! empty($this->kontak)) {
            $clean = preg_replace('/[^0-9]/', '', $this->kontak);
            if (str_starts_with($clean, '0')) {
                $clean = '62'.substr($clean, 1);
            }
            $nomor = $clean;
        }

        if (empty($nomor)) {
            return null;
        }

        $pesan = urlencode("Halo {$this->pemilik}, saya tertarik dengan produk {$this->nama} di SatuJarak Desa Jarak.");

        return "https://wa.me/{$nomor}?text={$pesan}";
    }

    /**
     * URL foto produk siap pakai untuk <img> tag.
     */
    public function getFotoUrlAttribute(): string
    {
        if (empty($this->foto)) {
            return asset('images/logoumkm.jpg');
        }

        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
            return $this->foto;
        }

        if (str_starts_with($this->foto, 'images/')) {
            return asset($this->foto);
        }

        if (str_starts_with($this->foto, 'potensi/')) {
            return asset('storage/'.$this->foto);
        }

        return asset('images/'.$this->foto);
    }
}

<?php

namespace Database\Factories;

use App\Models\PotensiDesa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PotensiDesa>
 */
class PotensiDesaFactory extends Factory
{
    protected $model = PotensiDesa::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nama = fake()->words(3, true);

        return [
            'nama' => ucfirst($nama),
            'slug' => Str::slug($nama),
            'kategori' => 'UMKM',
            'jenis_produk' => fake()->randomElement(['Kuliner', 'Kerajinan']),
            'pemilik' => fake()->name(),
            'lokasi' => 'Dusun Krajan, Desa Jarak',
            'kontak' => '081234567890',
            'whatsapp' => '6281234567890',
            'deskripsi' => fake()->paragraph(),
            'harga_teks' => 'Rp 15.000',
            'harga_mulai' => 15000,
            'harga_sampai' => 25000,
            'status' => 'Aktif',
            'is_featured' => false,
        ];
    }
}

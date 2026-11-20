<?php

namespace Database\Factories;

use App\Models\Layanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Layanan>
 */
class LayananFactory extends Factory
{
    protected $model = Layanan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $seq = 1;

        return [
            'kode_layanan' => 'LYN-'.str_pad($seq, 3, '0', STR_PAD_LEFT),
            'nama_layanan' => fake()->words(3, true),
            'kategori' => 'masyarakat',
            'deskripsi' => fake()->sentence(),
            'link_url' => 'https://example.com',
            'status' => 'Aktif',
            'urutan' => $seq++,
        ];
    }
}

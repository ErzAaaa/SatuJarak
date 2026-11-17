<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tambah kolom UMKM detail ke tabel potensi_desas.
     */
    public function up(): void
    {
        Schema::table('potensi_desas', function (Blueprint $table) {
            if (! Schema::hasColumn('potensi_desas', 'jenis_produk')) {
                $table->string('jenis_produk', 100)->nullable()->after('kategori')
                    ->comment('Jenis produk UMKM, misal: Kuliner, Kerajinan, Fashion, Pertanian');
            }

            if (! Schema::hasColumn('potensi_desas', 'harga_mulai')) {
                $table->decimal('harga_mulai', 12, 0)->nullable()->after('deskripsi')
                    ->comment('Harga produk mulai dari (Rp)');
            }

            if (! Schema::hasColumn('potensi_desas', 'harga_sampai')) {
                $table->decimal('harga_sampai', 12, 0)->nullable()->after('harga_mulai')
                    ->comment('Harga produk sampai (Rp), null jika harga tunggal');
            }

            if (! Schema::hasColumn('potensi_desas', 'foto_2')) {
                $table->string('foto_2', 255)->nullable()->after('foto')
                    ->comment('Foto tambahan produk ke-2');
            }

            if (! Schema::hasColumn('potensi_desas', 'foto_3')) {
                $table->string('foto_3', 255)->nullable()->after('foto_2')
                    ->comment('Foto tambahan produk ke-3');
            }

            if (! Schema::hasColumn('potensi_desas', 'sosmed')) {
                $table->string('sosmed', 255)->nullable()->after('kontak')
                    ->comment('Link media sosial atau marketplace (Shopee, Instagram, dsb)');
            }

            if (! Schema::hasColumn('potensi_desas', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('status')
                    ->comment('Produk unggulan yang ditampilkan di halaman utama');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('potensi_desas', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_produk',
                'harga_mulai',
                'harga_sampai',
                'foto_2',
                'foto_3',
                'sosmed',
                'is_featured',
            ]);
        });
    }
};

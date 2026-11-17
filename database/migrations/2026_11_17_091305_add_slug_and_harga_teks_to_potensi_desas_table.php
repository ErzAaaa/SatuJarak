<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('potensi_desas', function (Blueprint $table) {
            if (! Schema::hasColumn('potensi_desas', 'slug')) {
                $table->string('slug', 150)->nullable()->index()->after('nama')
                    ->comment('URL slug ramah SEO untuk detail UMKM');
            }

            if (! Schema::hasColumn('potensi_desas', 'harga_teks')) {
                $table->string('harga_teks', 100)->nullable()->after('deskripsi')
                    ->comment('Format teks harga bebas (misal: Rp14.000 - Rp150.000)');
            }

            if (! Schema::hasColumn('potensi_desas', 'whatsapp')) {
                $table->string('whatsapp', 50)->nullable()->after('kontak')
                    ->comment('Nomor WhatsApp format standar (misal: 6285736995477)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('potensi_desas', function (Blueprint $table) {
            $table->dropColumn(['slug', 'harga_teks', 'whatsapp']);
        });
    }
};

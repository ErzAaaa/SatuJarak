<?php

namespace Tests\Feature;

use App\Models\Layanan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLayananTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'is_admin' => true,
            'role' => 'Admin',
            'status' => 'Aktif',
        ]);
    }

    public function test_admin_can_view_layanan_index_with_next_id(): void
    {
        Layanan::factory()->create(['kode_layanan' => 'LYN-001', 'urutan' => 1]);
        Layanan::factory()->create(['kode_layanan' => 'LYN-002', 'urutan' => 2]);

        $response = $this->actingAs($this->admin)->get(route('admin.layanan.index'));
        $response->assertOk();
        $response->assertSee('LYN-003');
    }

    public function test_admin_can_create_layanan_with_auto_id(): void
    {
        Layanan::factory()->create(['kode_layanan' => 'LYN-001', 'urutan' => 1]);

        $response = $this->actingAs($this->admin)->post(route('admin.layanan.store'), [
            'nama_layanan' => 'Layanan Pembuatan KTP Baru',
            'kategori' => 'Kependudukan',
            'deskripsi' => 'Pengurusan KTP secara online.',
        ]);

        $response->assertRedirect(route('admin.layanan.index'));
        $this->assertDatabaseHas('layanans', [
            'nama_layanan' => 'Layanan Pembuatan KTP Baru',
            'kode_layanan' => 'LYN-002',
            'urutan' => 2,
        ]);
    }

    public function test_deleting_layanan_in_middle_automatically_reorders_remaining_ids(): void
    {
        $lyn1 = Layanan::factory()->create(['nama_layanan' => 'Layanan Satu', 'kode_layanan' => 'LYN-001', 'urutan' => 1]);
        $lyn2 = Layanan::factory()->create(['nama_layanan' => 'Layanan Dua', 'kode_layanan' => 'LYN-002', 'urutan' => 2]);
        $lyn3 = Layanan::factory()->create(['nama_layanan' => 'Layanan Tiga', 'kode_layanan' => 'LYN-003', 'urutan' => 3]);
        $lyn4 = Layanan::factory()->create(['nama_layanan' => 'Layanan Empat', 'kode_layanan' => 'LYN-004', 'urutan' => 4]);

        // Hapus nomor 2 di tengah-tengah
        $response = $this->actingAs($this->admin)->delete(route('admin.layanan.destroy', $lyn2->id));
        $response->assertRedirect(route('admin.layanan.index'));

        $this->assertDatabaseMissing('layanans', ['id' => $lyn2->id]);

        // Pastikan lyn1 tetap LYN-001
        $this->assertEquals('LYN-001', $lyn1->fresh()->kode_layanan);
        $this->assertEquals(1, $lyn1->fresh()->urutan);

        // Pastikan lyn3 bergeser dari LYN-003 menjadi LYN-002
        $this->assertEquals('LYN-002', $lyn3->fresh()->kode_layanan);
        $this->assertEquals(2, $lyn3->fresh()->urutan);

        // Pastikan lyn4 bergeser dari LYN-004 menjadi LYN-003
        $this->assertEquals('LYN-003', $lyn4->fresh()->kode_layanan);
        $this->assertEquals(3, $lyn4->fresh()->urutan);
    }
}

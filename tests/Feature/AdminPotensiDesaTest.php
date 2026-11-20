<?php

namespace Tests\Feature;

use App\Models\PotensiDesa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPotensiDesaTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'is_admin' => true,
            'role' => 'Admin',
            'status' => 'Aktif',
        ]);

        $this->regularUser = User::factory()->create([
            'is_admin' => false,
            'role' => 'User',
            'status' => 'Aktif',
        ]);
    }

    public function test_guest_cannot_access_potensi_desa_admin(): void
    {
        $response = $this->get(route('admin.potensi.index'));
        $response->assertRedirect('/login');
    }

    public function test_regular_user_cannot_access_potensi_desa_admin(): void
    {
        $response = $this->actingAs($this->regularUser)->get(route('admin.potensi.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_potensi_desa_index(): void
    {
        PotensiDesa::factory()->create([
            'nama' => 'Keripik Tempe Krajan',
            'kategori' => 'UMKM',
            'status' => 'Aktif',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.potensi.index'));
        $response->assertOk();
        $response->assertSee('Keripik Tempe Krajan');
    }

    public function test_admin_can_create_new_potensi_desa(): void
    {
        Storage::fake('public');

        $data = [
            'nama' => 'Kopi Robusta Dusun Jarak',
            'kategori' => 'UMKM',
            'status' => 'Aktif',
            'lokasi' => 'Dusun Jarak Krajan',
            'pemilik' => 'Pak Slamet',
            'kontak' => '081234567890',
            'harga_teks' => 'Rp 25.000 / bungkus',
            'deskripsi' => 'Kopi petik merah asli lereng pegunungan Desa Jarak.',
            'foto' => UploadedFile::fake()->image('kopi.jpg', 600, 400),
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.potensi.store'), $data);

        $response->assertRedirect(route('admin.potensi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('potensi_desas', [
            'nama' => 'Kopi Robusta Dusun Jarak',
            'pemilik' => 'Pak Slamet',
            'slug' => 'kopi-robusta-dusun-jarak',
            'whatsapp' => '6281234567890',
        ]);

        $created = PotensiDesa::where('nama', 'Kopi Robusta Dusun Jarak')->first();
        $this->assertNotNull($created->foto);
        Storage::disk('public')->assertExists($created->foto);
    }

    public function test_admin_can_update_potensi_desa(): void
    {
        $potensi = PotensiDesa::factory()->create([
            'nama' => 'Madu Hutan Liar',
            'kategori' => 'UMKM',
            'status' => 'Draft',
            'lokasi' => 'Dusun Tegalrejo',
            'pemilik' => 'Bu Siti',
            'deskripsi' => 'Madu murni alami.',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.potensi.update', $potensi), [
            'nama' => 'Madu Hutan Liar Super',
            'kategori' => 'UMKM',
            'status' => 'Aktif',
            'lokasi' => 'Dusun Tegalrejo',
            'pemilik' => 'Bu Siti',
            'kontak' => '08987654321',
            'harga_teks' => 'Rp 80.000',
            'deskripsi' => 'Madu murni alami diperbarui.',
        ]);

        $response->assertRedirect(route('admin.potensi.index'));
        $this->assertDatabaseHas('potensi_desas', [
            'id' => $potensi->id,
            'nama' => 'Madu Hutan Liar Super',
            'status' => 'Aktif',
        ]);
    }

    public function test_admin_can_delete_potensi_desa(): void
    {
        $potensi = PotensiDesa::factory()->create([
            'nama' => 'Kerajinan Anyaman Bambu',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.potensi.destroy', $potensi));

        $response->assertRedirect(route('admin.potensi.index'));
        $this->assertDatabaseMissing('potensi_desas', [
            'id' => $potensi->id,
        ]);
    }

    public function test_admin_can_create_umkm_with_makanan_and_kerajinan_categories(): void
    {
        // 1. Tambah Makanan
        $resMakanan = $this->actingAs($this->admin)->post(route('admin.potensi.store'), [
            'nama' => 'Keripik Tempe Gurih',
            'kategori' => 'Makanan',
            'status' => 'Aktif',
            'lokasi' => 'Dusun Krajan',
            'pemilik' => 'Bu Lastri',
            'kontak' => '081234567891',
            'harga_teks' => 'Rp 10.000',
            'deskripsi' => 'Keripik tempe gurih dan renyah.',
        ]);
        $resMakanan->assertRedirect(route('admin.potensi.index'));
        $this->assertDatabaseHas('potensi_desas', [
            'nama' => 'Keripik Tempe Gurih',
            'kategori' => 'UMKM',
            'jenis_produk' => 'Makanan',
        ]);

        // 2. Tambah Kerajinan
        $resKerajinan = $this->actingAs($this->admin)->post(route('admin.potensi.store'), [
            'nama' => 'Tas Anyaman Bambu',
            'kategori' => 'Kerajinan',
            'status' => 'Aktif',
            'lokasi' => 'Dusun Sagi',
            'pemilik' => 'Pak Joko',
            'kontak' => '081234567892',
            'harga_teks' => 'Rp 50.000',
            'deskripsi' => 'Tas anyaman bambu khas desa.',
        ]);
        $resKerajinan->assertRedirect(route('admin.potensi.index'));
        $this->assertDatabaseHas('potensi_desas', [
            'nama' => 'Tas Anyaman Bambu',
            'kategori' => 'UMKM',
            'jenis_produk' => 'Kerajinan',
        ]);

        // 3. Cek halaman user UMKM menampilkan keduanya di section yang tepat
        $resUser = $this->get(route('laman-umkm'));
        $resUser->assertOk();
        $resUser->assertSee('Keripik Tempe Gurih');
        $resUser->assertSee('Tas Anyaman Bambu');
    }
}

<?php

namespace Tests\Feature;

use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_and_regular_user_cannot_access_user_management(): void
    {
        $this->get(route('admin.users.index'))->assertRedirect(route('login'));

        $regularUser = User::factory()->create(['is_admin' => false, 'role' => 'User']);
        $this->actingAs($regularUser)->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_admin_can_view_users_list_and_realtime_stats(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'role' => 'Admin']);
        $user1 = User::factory()->create(['name' => 'Budi Santoso', 'role' => 'User']);
        $user2 = User::factory()->create(['name' => 'Siti Aminah', 'role' => 'User']);

        // Simulasi sesi online untuk user1
        DB::table('sessions')->insert([
            'id' => 'online-session-test',
            'user_id' => $user1->id,
            'ip_address' => '192.168.1.100',
            'user_agent' => 'Mozilla/5.0 TestBrowser',
            'payload' => base64_encode(serialize([])),
            'last_activity' => time(),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertOk();
        $response->assertSee('Kelola Pengguna');
        $response->assertSee('Budi Santoso');
        $response->assertSee('Siti Aminah');
        $response->assertSee('Online Sekarang');
    }

    public function test_admin_can_search_and_filter_users(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'role' => 'Admin']);
        User::factory()->create(['name' => 'Aditya Pratama', 'email' => 'aditya@example.com']);
        User::factory()->create(['name' => 'Bagus Setiawan', 'email' => 'bagus@example.com']);

        $res = $this->actingAs($admin)->get(route('admin.users.index', ['search' => 'Aditya']));
        $res->assertOk();
        $res->assertSee('Aditya Pratama');
        $res->assertDontSee('Bagus Setiawan');
    }

    public function test_admin_can_create_new_user(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'role' => 'Admin']);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Pengguna Baru',
            'email' => 'baru@satujarak.desa.id',
            'password' => 'secret123',
            'role' => 'User',
            'status' => 'Aktif',
            'no_hp' => '081234567890',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Pengguna Baru',
            'email' => 'baru@satujarak.desa.id',
            'role' => 'User',
            'status' => 'Aktif',
            'no_hp' => '081234567890',
            'is_admin' => false,
        ]);
    }

    public function test_admin_can_update_user_role_and_status(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'role' => 'Admin']);
        $user = User::factory()->create(['role' => 'User', 'status' => 'Aktif', 'is_admin' => false]);

        $response = $this->actingAs($admin)->patch(route('admin.users.update', $user->id), [
            'name' => 'Nama Terupdate',
            'email' => $user->email,
            'role' => 'Admin',
            'status' => 'Nonaktif',
            'no_hp' => '0899999999',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Terupdate',
            'role' => 'Admin',
            'status' => 'Nonaktif',
            'is_admin' => true,
        ]);
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'role' => 'Admin']);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin->id));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_can_delete_other_user(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'role' => 'Admin']);
        $targetUser = User::factory()->create(['name' => 'Target User']);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $targetUser->id));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
    }

    public function test_admin_can_view_user_detail_with_their_pengajuans_and_sessions(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'role' => 'Admin']);
        $user = User::factory()->create(['name' => 'Pemohon Mahasiswa']);

        $pengajuan = Pengajuan::create([
            'user_id' => $user->id,
            'nama_lengkap' => $user->name,
            'email_pemohon' => $user->email,
            'no_hp' => '081234567890',
            'nama_instansi' => 'Universitas Indonesia',
            'jenis_kegiatan' => 'KKN',
            'judul_kerjasama' => 'Program Riset Desa 2026',
            'status' => 'Menunggu Verifikasi',
        ]);

        DB::table('sessions')->insert([
            'id' => 'user-detail-session',
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Google Chrome Test Agent',
            'payload' => base64_encode(serialize([])),
            'last_activity' => time(),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.show', $user->id));

        $response->assertOk();
        $response->assertSee('Pemohon Mahasiswa');
        $response->assertSee('Program Riset Desa 2026');
        $response->assertSee('127.0.0.1');
        $response->assertSee('Online Sekarang');
    }

    public function test_admin_action_status_is_reflected_on_user_end_in_realtime(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'role' => 'Admin']);
        $user = User::factory()->create(['name' => 'Farhan Pemohon']);

        $pengajuan = Pengajuan::create([
            'user_id' => $user->id,
            'nama_lengkap' => $user->name,
            'email_pemohon' => $user->email,
            'no_hp' => '081234567890',
            'nama_instansi' => 'Universitas Indonesia',
            'jenis_kegiatan' => 'KKN',
            'judul_kerjasama' => 'Program Desa Cerdas',
            'status' => 'Menunggu Verifikasi',
            'catatan_admin' => null,
        ]);

        // 1. Admin tolak pengajuan dengan catatan
        $this->actingAs($admin)->patch(route('admin.pengajuan.update', $pengajuan->id), [
            'status' => 'Ditolak',
            'catatan_admin' => 'Proposal belum dilampirkan tanda tangan dosen pembimbing.',
        ])->assertRedirect(route('admin.pengajuan.show', $pengajuan->id));

        // 2. User login dan melihat detail pengajuan miliknya
        $userResponse = $this->actingAs($user)->get(route('pengajuan.show', $pengajuan->id));
        $userResponse->assertOk();
        $userResponse->assertSee('Ditolak');
        $userResponse->assertSee('Proposal belum dilampirkan tanda tangan dosen pembimbing.');

        // 3. Admin kemudian mengubah status menjadi Selesai (Disetujui)
        $this->actingAs($admin)->patch(route('admin.pengajuan.update', $pengajuan->id), [
            'status' => 'Selesai',
            'catatan_admin' => 'Berkas telah lengkap dan disetujui.',
        ])->assertRedirect(route('admin.pengajuan.show', $pengajuan->id));

        // 4. User melihat status berubah menjadi Selesai dan tombol unduh surat aktif
        $userResponseUpdated = $this->actingAs($user)->get(route('pengajuan.show', $pengajuan->id));
        $userResponseUpdated->assertOk();
        $userResponseUpdated->assertSee('Selesai');
        $userResponseUpdated->assertSee('Unduh Surat Persetujuan');
    }
}

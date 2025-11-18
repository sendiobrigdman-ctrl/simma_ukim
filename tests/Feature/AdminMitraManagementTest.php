<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Mitra;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminMitraManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_mitra_index()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)
            ->get('/admin/mitra')
            ->assertOk();
    }

    public function test_non_admin_cannot_access_mitra_index()
    {
        $dosen = User::factory()->create(['role' => 'dosen']);
        $this->actingAs($dosen)
            ->get('/admin/mitra')
            ->assertStatus(403);
    }

    public function test_admin_can_create_mitra()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $data = [
            'nama_perusahaan' => 'PT Sukses Selalu',
            'alamat' => 'Jl. Mawar No. 1',
            'email_kontak' => 'kontak@ptss.com',
            'telepon_kontak' => '08123456789',
            'status' => 'aktif',
        ];
        $this->actingAs($admin)
            ->post('/admin/mitra', $data)
            ->assertRedirect('/admin/mitra');
        $this->assertDatabaseHas('mitras', $data);
    }

    public function test_admin_can_update_mitra()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $mitra = Mitra::create([
            'nama_perusahaan' => 'PT Lama',
            'alamat' => 'Jl. Lama',
            'email_kontak' => 'lama@pt.com',
            'telepon_kontak' => '0811111111',
            'status' => 'aktif',
        ]);
        $update = [
            'nama_perusahaan' => 'PT Baru',
            'alamat' => 'Jl. Baru',
            'email_kontak' => 'baru@pt.com',
            'telepon_kontak' => '0822222222',
            'status' => 'non-aktif',
        ];
        $this->actingAs($admin)
            ->put("/admin/mitra/{$mitra->id}", $update)
            ->assertRedirect('/admin/mitra');
        $this->assertDatabaseHas('mitras', $update);
    }

    public function test_admin_can_delete_mitra()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $mitra = Mitra::create([
            'nama_perusahaan' => 'PT Hapus',
            'alamat' => 'Jl. Hapus',
            'email_kontak' => 'hapus@pt.com',
            'telepon_kontak' => '0833333333',
            'status' => 'aktif',
        ]);
        $this->actingAs($admin)
            ->delete("/admin/mitra/{$mitra->id}")
            ->assertRedirect('/admin/mitra');
        $this->assertDatabaseMissing('mitras', ['id' => $mitra->id]);
    }
}

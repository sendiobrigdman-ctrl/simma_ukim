<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use App\Models\Logbook;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardRoutingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_sees_admin_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Admin Dashboard');
    }

    public function test_mitra_sees_mitra_dashboard_with_counts()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);

        // create a lowongan and application to influence counts
        $low = Lowongan::create(['title' => 'L', 'description' => 'd', 'mitra_id' => $mitra->id, 'status' => Lowongan::STATUS_APPROVED]);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        Aplikasi::create(['user_id' => $mahasiswa->id, 'lowongan_id' => $low->id, 'status_aplikasi' => 'pending']);

        $this->actingAs($mitra)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Mitra Dashboard')
            ->assertSee('Active Jobs');
    }

    public function test_mahasiswa_sees_mahasiswa_dashboard()
    {
        $mhs = User::factory()->create(['role' => 'mahasiswa']);

        // create an aplikasi and today's logbook
        $low = Lowongan::create(['title' => 'L', 'description' => 'd', 'status' => Lowongan::STATUS_APPROVED]);
        Aplikasi::create(['user_id' => $mhs->id, 'lowongan_id' => $low->id, 'status_aplikasi' => 'pending']);
        Logbook::create(['user_id' => $mhs->id, 'tanggal' => now()->toDateString(), 'jam_mulai' => '09:00', 'jam_selesai' => '10:00', 'aktivitas' => 'test', 'status' => Logbook::STATUS_PENDING]);

        $this->actingAs($mhs)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Mahasiswa Dashboard')
            ->assertSee('Active Applications');
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertSee('Admin Dashboard')
            ->assertSee('Total Pengguna')
            ->assertSee('Total Lowongan')
            ->assertSee('Total Aplikasi')
            ->assertSee('Total Mitra');
    }

    public function test_non_admin_cannot_access_dashboard()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $this->actingAs($user)
            ->get('/admin')
            ->assertStatus(403);
    }
}

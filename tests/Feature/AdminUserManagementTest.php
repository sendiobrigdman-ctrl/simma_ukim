<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin/users')->assertRedirect('/login');
    }

    public function test_non_admin_cannot_access_admin_users_index(): void
    {
        $user = User::factory()->create(['role' => 'mitra']);

        $this->actingAs($user)
            ->get('/admin/users')
            ->assertStatus(403);
    }

    public function test_admin_can_access_admin_users_index(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->get('/admin/users')
            ->assertOk();
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)
            ->post('/admin/users', [
                'name' => 'Test User',
                'email' => 'testuser@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'role' => 'mahasiswa',
            ])
            ->assertRedirect('/admin/users');

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'role' => 'mahasiswa',
        ]);
    }

    public function test_admin_can_update_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'mahasiswa']);

        $this->actingAs($admin)
            ->put("/admin/users/{$user->id}", [
                'name' => 'Updated Name',
                'email' => $user->email,
                'role' => 'dosen',
                'password' => '',
                'password_confirmation' => '',
            ])
            ->assertRedirect('/admin/users');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'role' => 'dosen',
        ]);
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'mahasiswa']);

        $this->actingAs($admin)
            ->delete("/admin/users/{$user->id}")
            ->assertRedirect('/admin/users');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}

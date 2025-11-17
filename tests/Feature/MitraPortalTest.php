<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
 

class MitraPortalTest extends TestCase
{
	use RefreshDatabase;

	public function test_guest_is_redirected_to_login(): void
	{
		$this->get('/mitra')->assertRedirect('/login');
	}

	public function test_non_mitra_cannot_access_mitra_portal(): void
	{
		$user = User::factory()->create(['role' => 'mahasiswa']);

		$this->actingAs($user)
			->get('/mitra')
			->assertStatus(403);
	}

	public function test_mitra_can_access_dashboard(): void
	{
		$user = User::factory()->create(['role' => 'mitra']);

		$this->actingAs($user)
			->get('/mitra')
			->assertOk();
	}
}


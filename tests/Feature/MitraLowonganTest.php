<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lowongan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MitraLowonganTest extends TestCase
{
    use RefreshDatabase;

    public function test_mitra_can_view_lowongans_index()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        Lowongan::factory()->create(['mitra_id' => $mitra->id]);

        $response = $this->actingAs($mitra)->get(route('mitra.lowongans.index'));

        $response->assertStatus(200)
            ->assertViewHas('lowongans');
    }

    public function test_mitra_can_create_lowongan()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);

        $response = $this->actingAs($mitra)->post(route('mitra.lowongans.store'), [
            'title' => 'Lowongan Test',
            'description' => 'Test Description',
            'position' => 'Developer',
            'location' => 'Jakarta',
            'salary' => '10 juta',
        ]);

        $response->assertRedirect(route('mitra.lowongans.index'));

        $this->assertDatabaseHas('lowongans', [
            'title' => 'Lowongan Test',
            'mitra_id' => $mitra->id,
        ]);
    }

    public function test_mitra_can_view_lowongan_detail()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);

        $response = $this->actingAs($mitra)->get(route('mitra.lowongans.show', $lowongan));

        $response->assertStatus(200)
            ->assertViewHas('lowongan', $lowongan);
    }

    public function test_mitra_can_edit_own_lowongan()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id, 'title' => 'Old Title']);

        $response = $this->actingAs($mitra)->put(route('mitra.lowongans.update', $lowongan), [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);

        $response->assertRedirect(route('mitra.lowongans.show', $lowongan));

        $this->assertDatabaseHas('lowongans', [
            'id' => $lowongan->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_mitra_cannot_edit_other_mitra_lowongan()
    {
        $mitra1 = User::factory()->create(['role' => 'mitra']);
        $mitra2 = User::factory()->create(['role' => 'mitra']);
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra1->id]);

        $response = $this->actingAs($mitra2)->put(route('mitra.lowongans.update', $lowongan), [
            'title' => 'Hacked Title',
        ]);

        $response->assertForbidden();
    }

    public function test_mitra_can_delete_own_lowongan()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);

        $response = $this->actingAs($mitra)->delete(route('mitra.lowongans.destroy', $lowongan));

        $response->assertRedirect(route('mitra.lowongans.index'));

        $this->assertDatabaseMissing('lowongans', [
            'id' => $lowongan->id,
        ]);
    }

    public function test_non_mitra_cannot_access_lowongans()
    {
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $response = $this->actingAs($mahasiswa)->get(route('mitra.lowongans.index'));

        $response->assertForbidden();
    }

    public function test_unauthenticated_user_redirected_to_login()
    {
        $response = $this->get(route('mitra.lowongans.index'));

        $response->assertRedirect(route('login'));
    }
}

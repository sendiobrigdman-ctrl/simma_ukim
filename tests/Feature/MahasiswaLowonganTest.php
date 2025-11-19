<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MahasiswaLowonganTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_can_view_index_and_show()
    {
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $lowongan = Lowongan::create(['title' => 'Lowongan Test', 'description' => 'Deskripsi']);

        $this->actingAs($mahasiswa)
            ->get('/lowongan')
            ->assertOk()
            ->assertSee('Lowongan Tersedia')
            ->assertSee('Lowongan Test');

        $this->actingAs($mahasiswa)
            ->get("/lowongan/{$lowongan->id}")
            ->assertOk()
            ->assertSee('Lowongan Test')
            ->assertSee('Ajukan Lamaran');
    }

    public function test_mahasiswa_can_apply_to_lowongan()
    {
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $lowongan = Lowongan::create(['title' => 'Lowongan Apply', 'description' => 'Desc']);

        $this->actingAs($mahasiswa)
            ->post("/lowongan/{$lowongan->id}/apply")
            ->assertRedirect('/lowongan');

        $this->assertDatabaseHas('aplikasis', [
            'user_id' => $mahasiswa->id,
            'lowongan_id' => $lowongan->id,
        ]);
    }

    public function test_non_mahasiswa_cannot_access_lowongan_routes()
    {
        $dosen = User::factory()->create(['role' => 'dosen']);
        $lowongan = Lowongan::create(['title' => 'Lowongan Test', 'description' => 'Deskripsi']);

        $this->actingAs($dosen)
            ->get('/lowongan')
            ->assertStatus(403);

        $this->actingAs($dosen)
            ->get("/lowongan/{$lowongan->id}")
            ->assertStatus(403);

        $this->actingAs($dosen)
            ->post("/lowongan/{$lowongan->id}/apply")
            ->assertStatus(403);
    }
}

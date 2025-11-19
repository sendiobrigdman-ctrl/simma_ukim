<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MitraPelamarTest extends TestCase
{
    use RefreshDatabase;

    public function test_mitra_can_view_own_lowongan_applicants()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $lowongan = Lowongan::create(['title' => 'L', 'description' => 'D', 'mitra_id' => $mitra->id]);

        Aplikasi::create(['user_id' => $mahasiswa->id, 'lowongan_id' => $lowongan->id]);

        $this->actingAs($mitra)
            ->get("/mitra/lowongan/{$lowongan->id}/pelamar")
            ->assertOk()
            ->assertSee('Pelamar untuk')
            ->assertSee($mahasiswa->name);
    }

    public function test_mitra_can_update_application_status()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $lowongan = Lowongan::create(['title' => 'L', 'description' => 'D', 'mitra_id' => $mitra->id]);

        $aplikasi = Aplikasi::create(['user_id' => $mahasiswa->id, 'lowongan_id' => $lowongan->id, 'status_aplikasi' => 'pending']);

        $this->actingAs($mitra)
            ->patch("/mitra/lamaran/{$aplikasi->id}/status", ['status_aplikasi' => 'diterima_mitra'])
            ->assertRedirect();

        $this->assertDatabaseHas('aplikasis', ['id' => $aplikasi->id, 'status_aplikasi' => 'diterima_mitra']);
    }

    public function test_mitra_cannot_view_other_company_applicants()
    {
        $mitraA = User::factory()->create(['role' => 'mitra']);
        $mitraB = User::factory()->create(['role' => 'mitra']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $lowongan = Lowongan::create(['title' => 'L', 'description' => 'D', 'mitra_id' => $mitraA->id]);

        Aplikasi::create(['user_id' => $mahasiswa->id, 'lowongan_id' => $lowongan->id]);

        $this->actingAs($mitraB)
            ->get("/mitra/lowongan/{$lowongan->id}/pelamar")
            ->assertStatus(403);
    }
}

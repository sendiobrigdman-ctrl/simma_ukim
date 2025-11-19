<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MahasiswaLowonganTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_can_view_index_and_show()
    {
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $lowongan = Lowongan::create(['title' => 'Lowongan Test', 'description' => 'Deskripsi', 'status' => Lowongan::STATUS_APPROVED]);

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
        $lowongan = Lowongan::create(['title' => 'Lowongan Apply', 'description' => 'Desc', 'status' => Lowongan::STATUS_APPROVED]);

        Storage::fake('local');

        $file = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');

        $this->actingAs($mahasiswa)
            ->post("/lowongan/{$lowongan->id}/apply", [
                'cv' => $file,
            ])
            ->assertRedirect('/lowongan');

        $aplikasi = Aplikasi::where('user_id', $mahasiswa->id)->where('lowongan_id', $lowongan->id)->first();
        $this->assertNotNull($aplikasi);
        $this->assertNotNull($aplikasi->cv_path);

        Storage::disk('local')->assertExists($aplikasi->cv_path);
    }

    public function test_non_mahasiswa_cannot_access_lowongan_routes()
    {
        $dosen = User::factory()->create(['role' => 'dosen']);
        $lowongan = Lowongan::create(['title' => 'Lowongan Test', 'description' => 'Deskripsi', 'status' => Lowongan::STATUS_APPROVED]);

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

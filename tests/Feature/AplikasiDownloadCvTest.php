<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class AplikasiDownloadCvTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_download_cv()
    {
        Storage::fake('local');

        $admin = User::factory()->create(['role' => 'admin']);
        $mitra = User::factory()->create(['role' => 'mitra']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $lowongan = Lowongan::create(['title' => 'L', 'description' => 'D', 'mitra_id' => $mitra->id]);

        $file = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');
        $path = $file->store('cvs');

        $aplikasi = Aplikasi::create([
            'user_id' => $mahasiswa->id,
            'lowongan_id' => $lowongan->id,
            'cv_path' => $path,
        ]);

        $this->actingAs($admin)
            ->get("/aplikasi/{$aplikasi->id}/download-cv")
            ->assertStatus(200)
            ->assertHeader('content-disposition');
    }

    public function test_mitra_owner_can_download_cv()
    {
        Storage::fake('local');

        $mitra = User::factory()->create(['role' => 'mitra']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $lowongan = Lowongan::create(['title' => 'L', 'description' => 'D', 'mitra_id' => $mitra->id]);

        $file = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');
        $path = $file->store('cvs');

        $aplikasi = Aplikasi::create([
            'user_id' => $mahasiswa->id,
            'lowongan_id' => $lowongan->id,
            'cv_path' => $path,
        ]);

        $this->actingAs($mitra)
            ->get("/aplikasi/{$aplikasi->id}/download-cv")
            ->assertStatus(200)
            ->assertHeader('content-disposition');
    }

    public function test_other_user_cannot_download_cv()
    {
        Storage::fake('local');

        $mitra = User::factory()->create(['role' => 'mitra']);
        $other = User::factory()->create(['role' => 'mitra']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $lowongan = Lowongan::create(['title' => 'L', 'description' => 'D', 'mitra_id' => $mitra->id]);

        $file = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');
        $path = $file->store('cvs');

        $aplikasi = Aplikasi::create([
            'user_id' => $mahasiswa->id,
            'lowongan_id' => $lowongan->id,
            'cv_path' => $path,
        ]);

        $this->actingAs($other)
            ->get("/aplikasi/{$aplikasi->id}/download-cv")
            ->assertStatus(403);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class AplikasiCvDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_cv_file_deleted_when_aplikasi_deleted()
    {
        Storage::fake('local');

        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $mitra = User::factory()->create(['role' => 'mitra']);

        $lowongan = Lowongan::create(['title' => 'L', 'description' => 'D', 'mitra_id' => $mitra->id]);

        $file = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');
        $path = $file->store('cvs');

        $aplikasi = Aplikasi::create([
            'user_id' => $mahasiswa->id,
            'lowongan_id' => $lowongan->id,
            'cv_path' => $path,
        ]);

        // Ensure file exists
        Storage::disk('local')->assertExists($path);

        // Delete aplikasi
        $aplikasi->delete();

        // Assert file was deleted
        Storage::disk('local')->assertMissing($path);
    }
}

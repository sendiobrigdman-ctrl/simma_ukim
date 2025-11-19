<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use App\Models\Penilaian;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SertifikatTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_view_own_certificate()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $lowongan = Lowongan::create(['title' => 'Lowongan', 'description' => 'Desc', 'mitra_id' => $mitra->id, 'status' => Lowongan::STATUS_APPROVED]);

        $aplikasi = Aplikasi::create(['user_id' => $mahasiswa->id, 'lowongan_id' => $lowongan->id, 'status_aplikasi' => 'diterima_mitra']);

        $penilaian = Penilaian::create(['aplikasi_id' => $aplikasi->id, 'nilai_disiplin' => 80, 'nilai_kerja' => 90]);

        $this->actingAs($mahasiswa)
            ->get(route('mahasiswa.sertifikat.show', $penilaian))
            ->assertOk()
            ->assertSee('Sertifikat Magang')
            ->assertSee('Telah menyelesaikan magang dengan nilai');
    }

    public function test_student_cannot_view_others_certificate()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $other = User::factory()->create(['role' => 'mahasiswa']);

        $lowongan = Lowongan::create(['title' => 'Lowongan', 'description' => 'Desc', 'mitra_id' => $mitra->id, 'status' => Lowongan::STATUS_APPROVED]);

        $aplikasi = Aplikasi::create(['user_id' => $other->id, 'lowongan_id' => $lowongan->id, 'status_aplikasi' => 'diterima_mitra']);

        $penilaian = Penilaian::create(['aplikasi_id' => $aplikasi->id, 'nilai_disiplin' => 70, 'nilai_kerja' => 75]);

        $this->actingAs($mahasiswa)
            ->get(route('mahasiswa.sertifikat.show', $penilaian))
            ->assertStatus(403);
    }
}

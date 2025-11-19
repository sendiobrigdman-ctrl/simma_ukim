<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use App\Models\Penilaian;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PenilaianFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_mitra_submits_grade_and_student_can_view()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $lowongan = Lowongan::create(['title' => 'Lowongan', 'description' => 'Desc', 'mitra_id' => $mitra->id, 'status' => Lowongan::STATUS_APPROVED]);

        $aplikasi = Aplikasi::create(['user_id' => $mahasiswa->id, 'lowongan_id' => $lowongan->id, 'status_aplikasi' => 'diterima_mitra']);

        $this->actingAs($mitra)
            ->post(route('mitra.penilaian.store', $aplikasi), [
                'nilai_disiplin' => 80,
                'nilai_kerja' => 90,
                'catatan' => 'Baik kerjaannya',
            ])->assertRedirect();

        $this->assertDatabaseHas('penilaians', [
            'aplikasi_id' => $aplikasi->id,
            'nilai_disiplin' => 80,
            'nilai_kerja' => 90,
        ]);

        $this->actingAs($mahasiswa)
            ->get(route('mahasiswa.penilaian.show', $aplikasi))
            ->assertOk()
            ->assertSee('Nilai Disiplin')
            ->assertSee('80')
            ->assertSee('Rata-rata');
    }
}

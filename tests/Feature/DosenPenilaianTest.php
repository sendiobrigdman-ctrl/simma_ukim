<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Aplikasi;
use App\Models\Nilai;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DosenPenilaianTest extends TestCase
{
    use RefreshDatabase;

    public function test_dosen_can_view_penilaian_index()
    {
        $dosen = User::factory()->create(['role' => 'dosen']);

        $student = User::factory()->create();
        $aplikasi = Aplikasi::factory()->create(['dosen_id' => $dosen->id, 'user_id' => $student->id]);
        $log = Nilai::factory()->create(['aplikasi_id' => $aplikasi->id]);

        $response = $this->actingAs($dosen)->get(route('dosen.penilaian.index'));

        $response->assertStatus(200);
        $response->assertSee($aplikasi->user->name);
    }

    public function test_dosen_can_update_nilai()
    {
        $dosen = User::factory()->create(['role' => 'dosen']);

        $student = User::factory()->create();
        $aplikasi = Aplikasi::factory()->create(['dosen_id' => $dosen->id, 'user_id' => $student->id]);

        $response = $this->actingAs($dosen)->post(route('dosen.penilaian.update', $aplikasi), [
            'nilai_bimbingan' => 85,
            'nilai_laporan_akhir' => 90,
        ]);

        $response->assertRedirect(route('dosen.penilaian.index'));

        $this->assertDatabaseHas('nilais', [
            'aplikasi_id' => $aplikasi->id,
            'nilai_bimbingan' => 85,
            'nilai_laporan_akhir' => 90,
        ]);
    }

    public function test_dosen_cannot_edit_or_update_others_nilai()
    {
        $dosenA = User::factory()->create(['role' => 'dosen']);
        $dosenB = User::factory()->create(['role' => 'dosen']);

        $aplikasi = Aplikasi::factory()->create(['dosen_id' => $dosenB->id]);
        $nilai = Nilai::factory()->create(['aplikasi_id' => $aplikasi->id]);

        $resp1 = $this->actingAs($dosenA)->get(route('dosen.penilaian.edit', $aplikasi));
        $resp1->assertStatus(403);

        $resp2 = $this->actingAs($dosenA)->post(route('dosen.penilaian.update', $aplikasi), [
            'nilai_bimbingan' => 70,
            'nilai_laporan_akhir' => 75,
        ]);
        $resp2->assertStatus(403);

        $this->assertDatabaseHas('nilais', [
            'id' => $nilai->id,
        ]);
    }
}

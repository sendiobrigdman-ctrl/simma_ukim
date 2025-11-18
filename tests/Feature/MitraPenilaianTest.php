<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Aplikasi;
use App\Models\Lowongan;
use App\Models\Nilai;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MitraPenilaianTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that Mitra can view the penilaian index page.
     */
    public function test_mitra_can_view_penilaian_index()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $student = User::factory()->create();

        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);
        $aplikasi = Aplikasi::factory()->create(['lowongan_id' => $lowongan->id, 'user_id' => $student->id]);
        $nilai = Nilai::factory()->create(['aplikasi_id' => $aplikasi->id]);

        $response = $this->actingAs($mitra)->get(route('mitra.penilaian.index'));

        $response->assertStatus(200);
        $response->assertSee($student->name);
        $response->assertSee($lowongan->title);
    }

    /**
     * Test that Mitra can view the edit page for their own student's nilai.
     */
    public function test_mitra_can_view_edit_page_for_own_student()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $student = User::factory()->create();

        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);
        $aplikasi = Aplikasi::factory()->create(['lowongan_id' => $lowongan->id, 'user_id' => $student->id]);
        $nilai = Nilai::factory()->create(['aplikasi_id' => $aplikasi->id]);

        $response = $this->actingAs($mitra)->get(route('mitra.penilaian.edit', $aplikasi));

        $response->assertStatus(200);
        $response->assertSee($student->name);
    }

    /**
     * Test that Mitra can successfully update nilai_mitra.
     */
    public function test_mitra_can_update_nilai_mitra()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $student = User::factory()->create();

        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);
        $aplikasi = Aplikasi::factory()->create(['lowongan_id' => $lowongan->id, 'user_id' => $student->id]);

        $response = $this->actingAs($mitra)->post(route('mitra.penilaian.update', $aplikasi), [
            'nilai_mitra' => 88,
        ]);

        $response->assertRedirect(route('mitra.penilaian.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('nilais', [
            'aplikasi_id' => $aplikasi->id,
            'nilai_mitra' => 88,
        ]);
    }

    /**
     * Test that Mitra A cannot edit or update nilai for student of Mitra B (403 Forbidden).
     * This is the critical authorization test.
     */
    public function test_mitra_cannot_edit_or_update_other_mitra_student()
    {
        $mitraA = User::factory()->create(['role' => 'mitra']);
        $mitraB = User::factory()->create(['role' => 'mitra']);
        $student = User::factory()->create();

        // Create a lowongan for Mitra B
        $lowonganB = Lowongan::factory()->create(['mitra_id' => $mitraB->id]);
        // Create an aplikasi for that lowongan
        $aplikasi = Aplikasi::factory()->create(['lowongan_id' => $lowonganB->id, 'user_id' => $student->id]);
        $nilai = Nilai::factory()->create(['aplikasi_id' => $aplikasi->id]);

        // Mitra A tries to access edit page
        $editResponse = $this->actingAs($mitraA)->get(route('mitra.penilaian.edit', $aplikasi));
        $editResponse->assertStatus(403);

        // Mitra A tries to update nilai_mitra
        $updateResponse = $this->actingAs($mitraA)->post(route('mitra.penilaian.update', $aplikasi), [
            'nilai_mitra' => 75,
        ]);
        $updateResponse->assertStatus(403);

        // Verify the nilai was not changed
        $this->assertDatabaseHas('nilais', [
            'id' => $nilai->id,
            'nilai_mitra' => $nilai->nilai_mitra,
        ]);
    }

    /**
     * Test that non-authenticated users cannot access mitra penilaian routes.
     */
    public function test_unauthenticated_user_cannot_access_penilaian_routes()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);
        $aplikasi = Aplikasi::factory()->create(['lowongan_id' => $lowongan->id]);

        // Try to access index without authentication
        $response = $this->get(route('mitra.penilaian.index'));
        $response->assertRedirect(route('login'));

        // Try to access edit without authentication
        $response = $this->get(route('mitra.penilaian.edit', $aplikasi));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test that non-mitra users cannot access penilaian routes.
     */
    public function test_non_mitra_user_cannot_access_penilaian_routes()
    {
        $dosen = User::factory()->create(['role' => 'dosen']);
        $mitra = User::factory()->create(['role' => 'mitra']);
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);
        $aplikasi = Aplikasi::factory()->create(['lowongan_id' => $lowongan->id]);

        // Dosen tries to access mitra penilaian
        $response = $this->actingAs($dosen)->get(route('mitra.penilaian.index'));
        $response->assertStatus(403);
    }

    /**
     * Test validation: nilai_mitra must be between 0 and 100.
     */
    public function test_nilai_mitra_validation()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $student = User::factory()->create();

        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);
        $aplikasi = Aplikasi::factory()->create(['lowongan_id' => $lowongan->id, 'user_id' => $student->id]);

        // Test with value > 100
        $response = $this->actingAs($mitra)->post(route('mitra.penilaian.update', $aplikasi), [
            'nilai_mitra' => 150,
        ]);
        $response->assertSessionHasErrors('nilai_mitra');

        // Test with value < 0
        $response = $this->actingAs($mitra)->post(route('mitra.penilaian.update', $aplikasi), [
            'nilai_mitra' => -10,
        ]);
        $response->assertSessionHasErrors('nilai_mitra');

        // Test with valid value
        $response = $this->actingAs($mitra)->post(route('mitra.penilaian.update', $aplikasi), [
            'nilai_mitra' => 85,
        ]);
        $response->assertRedirect(route('mitra.penilaian.index'));
    }
}

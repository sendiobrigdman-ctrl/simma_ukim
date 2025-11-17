<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MitraAplikasiTest extends TestCase
{
    use RefreshDatabase;

    public function test_mitra_can_see_applicants_in_own_lowongan()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);
        
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $aplikasi = Aplikasi::factory()->create([
            'lowongan_id' => $lowongan->id,
            'user_id' => $mahasiswa->id,
            'status_aplikasi' => 'pending',
        ]);

        $response = $this->actingAs($mitra)->get(route('mitra.lowongans.show', $lowongan));

        $response->assertStatus(200)
            ->assertSee($mahasiswa->name)
            ->assertSee($aplikasi->status_label);
    }

    public function test_mitra_cannot_see_applicants_in_other_mitra_lowongan()
    {
        $mitra1 = User::factory()->create(['role' => 'mitra']);
        $mitra2 = User::factory()->create(['role' => 'mitra']);
        
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra1->id]);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        Aplikasi::factory()->create([
            'lowongan_id' => $lowongan->id,
            'user_id' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($mitra2)->get(route('mitra.lowongans.show', $lowongan));

        $response->assertForbidden();
    }

    public function test_mitra_can_accept_own_lowongan_applicant()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);
        
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $aplikasi = Aplikasi::factory()->create([
            'lowongan_id' => $lowongan->id,
            'user_id' => $mahasiswa->id,
            'status_aplikasi' => 'pending',
        ]);

        $response = $this->actingAs($mitra)
            ->patch(route('mitra.aplikasi.updateStatus', $aplikasi), [
                'status_aplikasi' => 'diterima_mitra',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('aplikasis', [
            'id' => $aplikasi->id,
            'status_aplikasi' => 'diterima_mitra',
        ]);
    }

    public function test_mitra_can_reject_own_lowongan_applicant()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);
        
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $aplikasi = Aplikasi::factory()->create([
            'lowongan_id' => $lowongan->id,
            'user_id' => $mahasiswa->id,
            'status_aplikasi' => 'pending',
        ]);

        $response = $this->actingAs($mitra)
            ->patch(route('mitra.aplikasi.updateStatus', $aplikasi), [
                'status_aplikasi' => 'ditolak_mitra',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('aplikasis', [
            'id' => $aplikasi->id,
            'status_aplikasi' => 'ditolak_mitra',
        ]);
    }

    public function test_mitra_cannot_update_applicant_status_in_other_mitra_lowongan()
    {
        $mitra1 = User::factory()->create(['role' => 'mitra']);
        $mitra2 = User::factory()->create(['role' => 'mitra']);
        
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra1->id]);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $aplikasi = Aplikasi::factory()->create([
            'lowongan_id' => $lowongan->id,
            'user_id' => $mahasiswa->id,
            'status_aplikasi' => 'pending',
        ]);

        $response = $this->actingAs($mitra2)
            ->patch(route('mitra.aplikasi.updateStatus', $aplikasi), [
                'status_aplikasi' => 'diterima_mitra',
            ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('aplikasis', [
            'id' => $aplikasi->id,
            'status_aplikasi' => 'pending',
        ]);
    }

    public function test_unauthenticated_user_cannot_update_applicant_status()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);
        
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $aplikasi = Aplikasi::factory()->create([
            'lowongan_id' => $lowongan->id,
            'user_id' => $mahasiswa->id,
        ]);

        $response = $this->patch(route('mitra.aplikasi.updateStatus', $aplikasi), [
            'status_aplikasi' => 'diterima_mitra',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_non_mitra_cannot_update_applicant_status()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);
        $aplikasi = Aplikasi::factory()->create([
            'lowongan_id' => $lowongan->id,
            'user_id' => $mahasiswa->id,
        ]);

        $response = $this->actingAs($mahasiswa)
            ->patch(route('mitra.aplikasi.updateStatus', $aplikasi), [
                'status_aplikasi' => 'diterima_mitra',
            ]);

        $response->assertForbidden();
    }

    public function test_mitra_can_see_no_applicants_message()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);

        $response = $this->actingAs($mitra)->get(route('mitra.lowongans.show', $lowongan));

        $response->assertStatus(200)
            ->assertSee('Belum ada pelamar');
    }
}

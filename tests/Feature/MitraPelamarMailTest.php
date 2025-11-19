<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Mail\LamaranStatusUpdated;

class MitraPelamarMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_mitra_updating_status_sends_mail_to_applicant()
    {
        Mail::fake();

        $mitra = User::factory()->create(['role' => 'mitra']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $lowongan = Lowongan::factory()->create(['mitra_id' => $mitra->id]);

        $aplikasi = Aplikasi::factory()->create([
            'user_id' => $mahasiswa->id,
            'lowongan_id' => $lowongan->id,
            'status_aplikasi' => 'pending',
        ]);

        $this->actingAs($mitra)
            ->patch("/mitra/lamaran/{$aplikasi->id}/status", ['status_aplikasi' => 'diterima_mitra'])
            ->assertRedirect();

        $this->assertDatabaseHas('aplikasis', [
            'id' => $aplikasi->id,
            'status_aplikasi' => 'diterima_mitra',
        ]);

        Mail::assertSent(LamaranStatusUpdated::class, function ($mail) use ($mahasiswa) {
            return $mail->hasTo($mahasiswa->email);
        });
    }
}

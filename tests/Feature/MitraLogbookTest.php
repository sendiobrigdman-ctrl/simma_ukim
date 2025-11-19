<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use App\Models\Logbook;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MitraLogbookTest extends TestCase
{
    use RefreshDatabase;

    public function test_mitra_can_approve_logbook()
    {
        $mitra = User::factory()->create(['role' => 'mitra']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $lowongan = Lowongan::create(['title' => 'Lowongan', 'description' => 'Desc', 'mitra_id' => $mitra->id, 'status' => Lowongan::STATUS_APPROVED]);

        $aplikasi = Aplikasi::create(['user_id' => $mahasiswa->id, 'lowongan_id' => $lowongan->id, 'status_aplikasi' => 'diterima_mitra']);

        $logbook = Logbook::create([
            'user_id' => $mahasiswa->id,
            'tanggal' => now()->toDateString(),
            'jam_mulai' => '09:00',
            'jam_selesai' => '11:00',
            'aktivitas' => 'Kegiatan A',
            'status' => Logbook::STATUS_PENDING,
        ]);

        $this->actingAs($mitra)
            ->patch(route('mitra.logbooks.updateStatus', $logbook), ['status' => Logbook::STATUS_APPROVED])
            ->assertRedirect();

        $this->assertDatabaseHas('logbooks', [
            'id' => $logbook->id,
            'status' => Logbook::STATUS_APPROVED,
        ]);
    }
}

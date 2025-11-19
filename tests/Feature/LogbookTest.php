<?php

namespace Tests\Feature;

use App\Models\Logbook;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LogbookTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_can_create_logbook_entry()
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'mahasiswa']);

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('kegiatan.jpg');

        $response = $this->post(route('mahasiswa.logbooks.store'), [
            'tanggal' => now()->format('Y-m-d'),
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'aktivitas' => 'Kerja di lab, pengujian sistem',
            'foto' => $file,
        ]);

        $response->assertRedirect(route('mahasiswa.logbooks.index'));

        $this->assertDatabaseHas('logbooks', [
            'user_id' => $user->id,
            'aktivitas' => 'Kerja di lab, pengujian sistem',
        ]);

        $log = Logbook::first();
        Storage::assertExists($log->foto_kegiatan_path);
    }

    public function test_validation_fails_when_end_time_before_start()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $this->actingAs($user);

        $response = $this->post(route('mahasiswa.logbooks.store'), [
            'tanggal' => now()->format('Y-m-d'),
            'jam_mulai' => '10:00',
            'jam_selesai' => '09:00',
            'aktivitas' => 'Invalid times',
        ]);

        $response->assertSessionHasErrors('jam_selesai');
    }

    public function test_validation_fails_when_tanggal_in_future()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $this->actingAs($user);

        $future = now()->addDay()->format('Y-m-d');

        $response = $this->post(route('mahasiswa.logbooks.store'), [
            'tanggal' => $future,
            'jam_mulai' => '08:00',
            'jam_selesai' => '09:00',
            'aktivitas' => 'Future date',
        ]);

        $response->assertSessionHasErrors('tanggal');
    }
}

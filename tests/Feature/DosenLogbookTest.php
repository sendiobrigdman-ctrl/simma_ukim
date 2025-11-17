<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Aplikasi;
use App\Models\Logbook;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DosenLogbookTest extends TestCase
{
    use RefreshDatabase;

    public function test_dosen_can_view_their_logbooks()
    {
        $dosen = User::factory()->create(['role' => 'dosen']);
        $other = User::factory()->create();

        $aplikasiMine = Aplikasi::factory()->create(['dosen_id' => $dosen->id]);
        $aplikasiOther = Aplikasi::factory()->create(['dosen_id' => $other->id]);

        $logMine = Logbook::factory()->create(['aplikasi_id' => $aplikasiMine->id, 'content' => 'Catatan saya']);
        $logOther = Logbook::factory()->create(['aplikasi_id' => $aplikasiOther->id, 'content' => 'Catatan lain']);

        $response = $this->actingAs($dosen)->get(route('dosen.logbook.index'));

        $response->assertStatus(200);
        $response->assertSee('Catatan saya');
        $response->assertDontSee('Catatan lain');
    }

    public function test_dosen_can_validate_logbook()
    {
        $dosen = User::factory()->create(['role' => 'dosen']);

        $aplikasi = Aplikasi::factory()->create(['dosen_id' => $dosen->id]);
        $log = Logbook::factory()->create(['aplikasi_id' => $aplikasi->id]);

        $response = $this->actingAs($dosen)
            ->post(route('dosen.logbook.update', $log), ['action' => 'validate']);

        $response->assertRedirect(route('dosen.logbook.index'));

        $this->assertDatabaseHas('logbooks', [
            'id' => $log->id,
            'status_validasi' => 'divalidasi',
        ]);
    }

    public function test_dosen_cannot_view_or_validate_others_logbook()
    {
        $dosenA = User::factory()->create(['role' => 'dosen']);
        $dosenB = User::factory()->create(['role' => 'dosen']);

        $aplikasi = Aplikasi::factory()->create(['dosen_id' => $dosenB->id]);
        $log = Logbook::factory()->create(['aplikasi_id' => $aplikasi->id, 'status_validasi' => 'menunggu', 'content' => 'Log milik B']);

        // Dosen A should not be able to view the individual logbook
        $response = $this->actingAs($dosenA)->get(route('dosen.logbook.show', $log));
        $response->assertStatus(403);

        // Dosen A should not be able to validate the logbook
        $response2 = $this->actingAs($dosenA)->post(route('dosen.logbook.update', $log), ['action' => 'validate']);
        $response2->assertStatus(403);

        $this->assertDatabaseHas('logbooks', [
            'id' => $log->id,
            'status_validasi' => 'menunggu',
        ]);
    }
}

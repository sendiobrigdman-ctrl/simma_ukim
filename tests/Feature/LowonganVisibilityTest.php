<?php

namespace Tests\Feature;

use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LowonganVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_sees_only_approved_lowongans()
    {
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        Lowongan::factory()->create(['title' => 'Approved One', 'status' => Lowongan::STATUS_APPROVED]);
        Lowongan::factory()->create(['title' => 'Pending One', 'status' => Lowongan::STATUS_PENDING]);

        $this->actingAs($mahasiswa);

        $response = $this->get(route('mahasiswa.lowongan.index'));

        $response->assertStatus(200);
        $response->assertSee('Approved One');
        $response->assertDontSee('Pending One');
    }
}

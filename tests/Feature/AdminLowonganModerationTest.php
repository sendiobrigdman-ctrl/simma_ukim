<?php

namespace Tests\Feature;

use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowonganStatusUpdated;
use Tests\TestCase;

class AdminLowonganModerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_and_reject_lowongan()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $mitra = User::factory()->create(['role' => 'mitra', 'email' => 'mitra@example.test']);
        $lowongan = Lowongan::factory()->create(['status' => Lowongan::STATUS_PENDING, 'mitra_id' => $mitra->id]);

        Mail::fake();

        $this->actingAs($admin);

        $response = $this->patch(route('admin.lowongans.moderation.updateStatus', $lowongan), [
            'status' => Lowongan::STATUS_APPROVED,
        ]);

        $response->assertRedirect(route('admin.lowongans.moderation.index'));

        $lowongan->refresh();
        $this->assertEquals(Lowongan::STATUS_APPROVED, $lowongan->status);

        Mail::assertSent(LowonganStatusUpdated::class, function ($mail) use ($mitra) {
            return $mail->hasTo($mitra->email);
        });
    }
}

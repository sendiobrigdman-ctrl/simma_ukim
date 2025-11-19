<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile_fields_and_upload_photo()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user);

        // Create an initial photo to ensure deletion happens
        $initial = UploadedFile::fake()->image('old.jpg');
        $initialPath = $initial->store('photos', 'public');
        $user->foto_path = $initialPath;
        $user->save();

        $newPhoto = UploadedFile::fake()->image('new.jpg');

        $response = $this->patch(route('profile.update'), [
            'name' => 'Updated Name',
            'email' => $user->email,
            'nim' => '20250001',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2025,
            'ipk' => '3.75',
            'no_hp' => '08123456789',
            'foto' => $newPhoto,
        ]);

        $response->assertRedirect(route('profile.edit'));

        $user->refresh();

        $this->assertEquals('20250001', $user->nim);
        $this->assertEquals('Teknik Informatika', $user->jurusan);
        $this->assertEquals(2025, $user->angkatan);
        $this->assertEquals('3.75', number_format($user->ipk, 2));
        $this->assertEquals('08123456789', $user->no_hp);

        // New photo exists on disk, old photo removed
        Storage::assertExists($user->foto_path);
        Storage::assertMissing($initialPath);
    }
}

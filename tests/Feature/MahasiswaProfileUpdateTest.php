<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MahasiswaProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_can_update_extended_profile_and_upload_photo()
    {
        Storage::fake('local');

        $user = User::factory()->create(['role' => 'mahasiswa']);

        // simulate existing photo
        Storage::put('photos/old.jpg', 'old');
        $user->foto_path = 'photos/old.jpg';
        $user->save();

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('newphoto.jpg');

        $response = $this->patch(route('profile.update'), [
            'name' => 'Updated Name',
            'email' => $user->email,
            'nim' => '12345678',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2022,
            'ipk' => '3.75',
            'no_hp' => '08123456789',
            'foto' => $file,
        ]);

        $response->assertRedirect(route('profile.edit'));

        $user->refresh();

        $this->assertEquals('12345678', $user->nim);
        $this->assertEquals('Teknik Informatika', $user->jurusan);
        $this->assertEquals(2022, $user->angkatan);
        $this->assertEquals(3.75, $user->ipk);
        $this->assertEquals('08123456789', $user->no_hp);

        // old file removed
        Storage::assertMissing('photos/old.jpg');

        // new file exists
        $this->assertNotNull($user->foto_path);
        Storage::assertExists($user->foto_path);
    }
}

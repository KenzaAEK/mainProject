<?php

namespace Tests\Feature;
namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Tuteur;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileUserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp():void{
        parent::setUp();
        $this->tuteur = Tuteur::factory()->create();
        $this->user = User::find($this->tuteur->idUser);
        $this->user2 = User::factory()->create();

    }

    public function test_profile_returns_authenticated_user()
    {
        Sanctum::actingAs($this->user);
        $response = $this->getJson('/api/profile');

        $response->assertStatus(200)
                 ->assertJson([
                     'user' => [
                         'nom' => $this->user->nom,
                         'prenom' => $this->user->prenom,
                         'email' => $this->user->email,
                         'tel' => $this->user->tel,
                        "role"=> "1",

                     ],
                 ]);
    }

    public function test_update_profile_updates_user_information()
    {
        Sanctum::actingAs($this->user);
        $data = [
            'nom' => 'UpdatedNom',
            'prenom' => 'UpdatedPrenom',
            'email' => 'updated@example.com',
            'tel' => '1234567890',
        ];

        $response = $this->patchJson('/api/udpdate-profile', $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Profil mis à jour avec succès.',
                     'user' => [
                         'nom' => 'UpdatedNom',
                         'prenom' => 'UpdatedPrenom',
                         'email' => 'updated@example.com',
                         'tel' => '1234567890',
                     ],
                 ]);

        $this->assertDatabaseHas('users', [
            'idUser' => $this->user->idUser,
            'nom' => 'UpdatedNom',
            'prenom' => 'UpdatedPrenom',
            'email' => 'updated@example.com',
            'tel' => '1234567890',
        ]);
    }

    public function test_upload_image_updates_user_photo()
    {
        Sanctum::actingAs($this->user);
        Storage::fake('public');

        $file = UploadedFile::fake()->image('profile.jpg');

        $response = $this->postJson('api/upload-image', [
            'image' => $file,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Image uploadée avec succès.',
                 ]);
                //  dd($file->name);
        $this->assertDatabaseHas('users', [
            'idUser' => $this->user->idUser,
            'photo' => time() . '_' .$file->name,
        ]);

        // Storage::disk('public')->assertExists('uploads/' . time() . '_' .$file->name);
    }

    public function test_upload_image_returns_error_if_no_image_provided()
    {
        Sanctum::actingAs($this->user);
        $response = $this->postJson('api/upload-image', []);

        $response->assertStatus(422)
                 ->assertJson([
                     'message' => 'The image field is required.',
                 ]);
    }



    public function test_update_profile_requires_authentication()
    {
        // Auth::logout();
        // Sanctum::actingAs($this->user2);

        $data = [
            'nom' => 'UpdatedNom',
            'prenom' => 'UpdatedPrenom',
            'email' => 'updated@example.com',
            'tel' => '1234567890',
        ];

        $response = $this->patchJson('/api/udpdate-profile', $data);

        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'Unauthenticated.',
                 ]);
    }

    public function test_upload_image_requires_authentication()
    {
        Auth::logout();

        $file = UploadedFile::fake()->image('profile.jpg');

        $response = $this->postJson('api/upload-image', [
            'image' => $file,
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'Unauthenticated.',
                 ]);
    }

    public function test_profile_requires_authentication()
    {
        Auth::logout();

        $response = $this->getJson('/api/profile');

        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'Unauthenticated.',
                 ]);
    }

    public function test_update_profile_with_invalid_data()
    {
        Sanctum::actingAs($this->user);
        $data = [
            'nom' => '',
            'prenom' => '',
            'email' => 'not-an-email',
            'tel' => '',
        ];

        $response = $this->patchJson('/api/udpdate-profile', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nom', 'prenom', 'email', 'tel']);
    }

    public function test_upload_invalid_image_file()
    {
        Sanctum::actingAs($this->user);
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $response = $this->postJson('api/upload-image', [
            'image' => $file,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['image']);
    }

    public function test_upload_image_without_file()
    {
        Sanctum::actingAs($this->user);
        $response = $this->postJson('api/upload-image');

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['image']);
    }
}

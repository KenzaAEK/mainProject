<?php

namespace Tests\Feature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Mockery;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Activite;
use App\Models\Administrateur;
use App\Models\TypeActivite;
use Tests\TestCase;

class AtelierControllerTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        // Create a user and animateur for testing
        $this->Admin = Administrateur::factory()->create();
        // dd($Anim);
        $this->user = User::find($this->Admin->idUser);
        // $this->offre = Offre::factory()->create();
        // $this->activite = Activite::factory(['titre' => 'Swimming'])->create();
        // $this->offreactivite = offreActivite::factory(['idOffre' => $this->offre->idOffre,'idActivite'=>$this->activite->idActivite])->create();
        // $this->user = User::factory()->create();
        // $this->animateur = Animateur::factory()->create(['idUser' => $this->user->id]);
    }
    
    public function test_index_returns_all_activities()
{
    // $user = User::factory()->create([
    //     "role"=>2
    // ]);
    Sanctum::actingAs($this->user);
    $activites = Activite::factory()->count(3)->create();
    // dd($activites);
    $response = $this->getJson("api/admin/activites");

    $response->assertOk();
    $response->assertJsonCount(3);
    $response->assertJson($activites->toArray());
}

public function test_store_new_activity_successfully()
{
    // $user = User::factory()->create([
    //     "role"=>2
    // ]);
    Sanctum::actingAs($this->user);

    $typeActivite = TypeActivite::factory()->create(['type' => 'Sport']);

    // Fake the storage to simulate file uploads
    Storage::fake('public');

    $activityData = [
        'titre' => 'Youth Soccer Training',
        'description' => 'A comprehensive soccer training program for youths.',
        'objectif' => 'Improve soccer skills and teamwork',
        'ageMin' => 10,
        'ageMax' => 15,
        'imagePub' => UploadedFile::fake()->image('defile.jpg'),
        'lienYtb' => 'https://youtube.com/example_video',
        'programmePdf' => UploadedFile::fake()->create('bdd.pdf', 1000, 'application/pdf'),
        'type' => 'Sport',
    ];

    $response = $this->postJson("api/admin/activites", $activityData);

    $response->assertStatus(201);
    $response->assertJsonFragment([
        'titre' => 'Youth Soccer Training',
        'idTypeActivite' => $typeActivite->idTypeActivite
    ]);
}



public function test_store_activity_with_invalid_type()
{
    // $user = User::factory()->create([
    //     "role"=>2
    // ]);
    Sanctum::actingAs($this->user);
    $activityData = [
        'titre' => 'Youth Soccer Training',
        'description' => 'A comprehensive soccer training program for youths.',
        'objectif' => 'Improve soccer skills and teamwork',
        'ageMin' => 10,
        'ageMax' => 15,
        'imagePub' => 'path/to/image.jpg',   // Use a valid path or simulate a file.
        'lienYtb' => 'https://youtube.com/example_video',
        'programmePdf' => 'path/to/program.pdf',  // Use a valid path or simulate a file.
        'name' => 'Soccer Class',
        'type' => 'InvalidType'  // This is the focus of the test
    ];

    $response = $this->postJson("api/admin/activites", $activityData);

    // Assuming your application treats invalid type as a validation error.
    $response->assertStatus(422); // Check for a validation failure status code.
    $response->assertJsonValidationErrors(['type']);
}



public function test_show_existing_activity()
{
    // $user = User::factory()->create([
    //     "role"=>2
    // ]);
    Sanctum::actingAs($this->user);
    $activite = Activite::factory()->create();

    $response = $this->getJson('api/admin/activites', ['id'=>$activite->idActivite]);
    // dd($response);
    $response->assertOk();
    $response->assertJsonFragment([
        'titre' => $activite->titre
    ]);
}


public function test_show_non_existing_activity()
{
    // $user = User::factory()->create([
    //     "role"=>2
    // ]);
    Sanctum::actingAs($this->user);
    $response = $this->getJson('api/admin/activites/9999999');

    $response->assertStatus(404);
}


public function test_update_existing_activity()
{
    // $user = User::factory()->create([
    //     "role"=>2
    // ]);
    Sanctum::actingAs($this->user);
    $activite = Activite::factory()->create();
    $typeActivite = TypeActivite::factory()->create(['type' => 'Music']);

    $response = $this->putJson("api/admin/activites/$activite->idActivite", [
        'titre' => 'Music Class',
        'type' => 'Music'
    ]);

    $response->assertOk();
    $response->assertJsonFragment([
        'titre' => 'Music Class'
    ]);
}

public function test_destroy_existing_activity()
{
    // $user = User::factory()->create([
    //     "role"=>2
    // ]);
    Sanctum::actingAs($this->user);
    $activite = Activite::factory()->create();

    $response = $this->deleteJson("api/admin/activites/$activite->idActivite");

    $response->assertOk();
}

public function test_unauthorized_access()
{
    $response = $this->getJson("api/admin/activites");
    $response->assertStatus(401); // Unauthorized

    $response = $this->postJson("api/admin/activites", []);
    $response->assertStatus(401); // Unauthorized

    $response = $this->putJson("api/admin/activites/1", []);
    $response->assertStatus(401); // Unauthorized

    $response = $this->deleteJson("api/admin/activites/1");
    $response->assertStatus(401); // Unauthorized
}

public function test_update_activity_with_invalid_data()
{
    // $user = User::factory()->create(["role" => 2]);
    Sanctum::actingAs($this->user);
    $activite = Activite::factory()->create();
    $invalidData = [
        'titre' => '',  // Empty title to trigger validation error
        'type' => 'NonexistentType'  // Invalid type to trigger another error
    ];

    $response = $this->putJson("api/admin/activites/$activite->idActivite", $invalidData);
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['titre', 'type']);
}


public function test_delete_non_existent_activity()
{
    // $user = User::factory()->create(["role" => 2]);
    Sanctum::actingAs($this->user);
    $response = $this->deleteJson("api/admin/activites/9999");
    $response->assertStatus(404);
}

public function test_activity_list_pagination()
{
    // $user = User::factory()->create(["role" => 2]);
    Sanctum::actingAs($this->user);
    Activite::factory()->count(50)->create();

    $response = $this->getJson("api/admin/activites?page=2");
    $response->assertOk();
    // print_r($response->assertJsonStructure());

}


public function test_handle_database_error_on_create()
{
    // $user = User::factory()->create(["role" => 2]);
    Sanctum::actingAs($this->user);

    DB::shouldReceive('beginTransaction')
      ->andThrow(new \Exception("Simulated database error"));

    $activityData = [
        'titre' => 'New Soccer Class',
        'description' => 'Soccer training',
        'objectif' => 'Training',
        'imagePub' => 'path/to/image.jpg',
        'lienYtb' => 'https://youtube.com/example_video',
        'programmePdf' => 'path/to/program.pdf',
        'type' => 'Sport'
    ];

    $response = $this->postJson("api/admin/activites", $activityData);
    $response->assertStatus(500); // Server error
}


// public function test_sql_injection_protection()
// {
//     $user = User::factory()->create(["role" => 2]);
//     Sanctum::actingAs($user);
//     $maliciousInput = "1; DROP TABLE users;--";
//     $response = $this->getJson("api/admin/activites?ageMin={$maliciousInput}");
//     $response->assertStatus(422); // Assuming your application validates numeric fields
// }

// public function test_database_outage_handling()
// {
//     $user = User::factory()->create(["role" => 2]);
//     Sanctum::actingAs($user);
//     DB::shouldReceive('connection')->andThrow(new \Exception('Database connection error'));

//     $response = $this->getJson("api/admin/activites");
//     $response->assertStatus(500); // Internal Server Error
//     $response->assertJson(['message' => 'Service temporarily unavailable']);
// }

public function test_prevent_duplicate_activities()
{
    // $user = User::factory()->create(["role" => 2]);
    
    Sanctum::actingAs($this->user);
    $typeActivite = TypeActivite::factory()->create(['type' => 'Sport']);
    $activityData = [
        'titre' => 'Chess Class',
        'description' => 'Learn chess strategies.',
        'objectif' => 'Strategic thinking',
        'imagePub' => UploadedFile::fake()->image('defile.jpg'),
        'lienYtb' => 'https://youtube.com/chess_intro',
        'programmePdf' => UploadedFile::fake()->create('bdd.pdf', 1000, 'application/pdf'),
        'type' => 'Sport'
    ];
    
    
    // Create the first instance
    $this->postJson("api/admin/activites", $activityData);

    // Attempt to create a duplicate
    $response = $this->postJson("api/admin/activites", $activityData);
    $response->assertStatus(500); // Conflict
    // $response->assertJson(['message' => ' Unique violation']);
}


// public function test_handle_external_service_failure()
// {
//     $user = User::factory()->create(["role" => 2]);
//     Sanctum::actingAs($user);
//     Http::fake([
//         'path/to/image.jpg' => Http::response('Error', 500)
//     ]);

//     $activityData = [
//         'titre' => 'Yoga Class',
//         'description' => 'Relaxing yoga sessions.',
//         'objectif' => 'Improve flexibility and reduce stress',
//         'ageMin' => 20,
//         'ageMax' => 60,
//         'imagePub' => 'path/to/image.jpg', // This will simulate a failure in image upload to an external service
//         'lienYtb' => 'https://youtube.com/yoga_session',
//         'programmePdf' => 'path/to/yoga_program.pdf',
//         'type' => 'Health'
//     ];

//     $response = $this->postJson("api/admin/activites", $activityData);
//     $response->assertStatus(500); // Internal Server Error
//     $response->assertJson(['message' => 'Failed to upload image, please try again']);
// }



}

<?php

namespace Tests\Feature;

// namespace Tests\Feature\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Mockery;

use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\offre;
use App\Models\offreActivite;
use App\Models\Administrateur;
use App\Models\Activite;
// use Database\Factories\Administrateur;
use Tests\TestCase;

class offreControllerTest extends TestCase
{
    use RefreshDatabase;
    
 
// public function test_it_returns_all_offre_activites_as_json()
// {

//     $user = User::factory()->create();
    
//     $response = $this->actingAs($user, 'sanctum')
//                      ->json('GET', '/api/offres');

//     $response->assertStatus(200)
//              ->assertJsonStructure([
//                  '*' => [
//                      'idOffre',
//                      'idActivite',
                    //  Add other offreActivite fields here
//                  ]
//              ]);
// }

/** @test */
public function it_successfully_creates_an_offre_with_valid_data()
{
    $admin = Administrateur::factory()->create();
    $activite = Activite::factory(['titre' => 'Swimming'])->create();
    $user = User::find($admin->idUser);

    // dd($admin);
    // $user = User::factory()->create(["role"=>2]);
    if (!$user) {
        dd('User is null, check factory setup.'.$user);
    }
    // dd($user);
    Sanctum::actingAs($user);
    $payload = [
        'titre' => 'Summer Camp',
        'remise' => 10,
        'dateDebutOffre' => '2024-06-01',
        'dateFinOffre' => '2024-08-01',
        'description' => 'A fun summer learning experience',
        'activites' =>[
            [
                'titre' => 'Swimming',
                'tarif' => 150,
                'effmax' => 30,
                'effmin' => 10,
                'age_min' => 7,
                'age_max' => 12,
                'jours' => [
                    [
                        'JourAtelier' => 'Monday',
                        'heureDebut' => '09:00',
                        'heureFin' => '11:00'
                    ],
                    // Additional days can be added here if needed
                ]
            ]
        ]
    ];

    //$response = $this->actingAs($user, 'sanctum')
    //                  ->json('POST', '/api/offres', $payload);
    
    $response = $this->postJson("api/offres/", $payload);
    $response->assertStatus(200)
             ->assertJson(['message' => 'Offre créée avec succès']);
}


/** @test */
public function it_shows_an_offre_with_its_activities()
{
    $admin = Administrateur::factory()->create();
    $user = User::find($admin->idUser);
    Sanctum::actingAs($user);
    $offreId = Offre::factory()->create()->idOffre;
    // dd($offreId);
    $response = $this->getJson("/api/offres/{$offreId}");
    // dd($response);
    $response->assertStatus(200)
             ->assertJsonStructure([
                 'offre' => [
                     'idOffre',
                     'titre',
                     
                 ],
                 'activites'
             ]);
}

/** @test */
public function it_updates_an_existing_offre()
{
    $admin = Administrateur::factory()->create();
    $user = User::find($admin->idUser);
    Sanctum::actingAs($user);
    $newTitle = 'Updated Title';
    $offre = Offre::factory()->create();
    $response = $this->putJson("/api/offres/{$offre->idOffre}", ['titre' => $newTitle]);

    $response->assertStatus(200)
             ->assertJson(['message' => 'Offre mise à jour avec succès']);
}

/** @test */
public function it_deletes_an_offre_activite_by_id()
{
    $user = factory(User::class)->create();
    $idOffre = 1;  // Use existing idOffre
    $idActivite = 1;  // Use existing idActivite

    $response = $this->actingAs($user, 'sanctum')
                     ->json('DELETE', "/api/offres/{$idOffre}/activites/{$idActivite}");

    $response->assertStatus(200)
             ->assertJson(['message' => 'Activité deleted successfully']);
}

/** @test */
public function it_creates_offre_with_multiple_activities_and_validates_them_successfully()
{
    $user = factory(User::class)->create();
    $payload = [
        'titre' => 'Winter Sessions',
        'remise' => 20,
        'dateDebutOffre' => '2024-12-01',
        'dateFinOffre' => '2025-02-01',
        'description' => 'Winter educational activities',
        'activites' => [
            [
                'titre' => 'Math Club',
                'tarif' => 100,
                'jours' => [
                    ['heureDebut' => '10:00', 'heureFin' => '12:00', 'JourAtelier' => 'Tuesday'],
                    ['heureDebut' => '10:00', 'heureFin' => '12:00', 'JourAtelier' => 'Thursday'],
                ]
            ],
            [
                'titre' => 'Science Lab',
                'tarif' => 120,
                'jours' => [
                    ['heureDebut' => '14:00', 'heureFin' => '16:00', 'JourAtelier' => 'Wednesday'],
                    ['heureDebut' => '14:00', 'heureFin' => '16:00', 'JourAtelier' => 'Friday'],
                ]
            ]
        ]
    ];

    $response = $this->actingAs($user, 'sanctum')
                     ->json('POST', '/api/offres', $payload);

    $response->assertStatus(200)
             ->assertJson(['message' => 'Offre créée avec succès']);
    $this->assertDatabaseHas('offres', ['titre' => 'Winter Sessions']);
    $this->assertDatabaseHas('activites', ['titre' => 'Math Club']);
    $this->assertDatabaseHas('activites', ['titre' => 'Science Lab']);
}

/** @test */
public function it_partially_updates_an_offre()
{
    $user = factory(User::class)->create();
    $offre = factory(Offre::class)->create(['titre' => 'Original Title']);
    $updateData = ['titre' => 'Updated Title'];

    $response = $this->actingAs($user, 'sanctum')
                     ->json('PUT', "/api/offres/{$offre->id}", $updateData);

    $response->assertStatus(200)
             ->assertJson(['message' => 'Offre mise à jour avec succès']);
    $this->assertDatabaseHas('offres', ['titre' => 'Updated Title']);
}

/** @test */
public function it_returns_error_when_deleting_activites_for_nonexistent_offre()
{
    $user = factory(User::class)->create();
    $nonExistentIdOffre = 999; // Assuming this ID does not exist

    $response = $this->actingAs($user, 'sanctum')
                     ->json('DELETE', "/api/offres/{$nonExistentIdOffre}/activites");

    $response->assertStatus(404);
}

/** @test */
public function it_handles_exceptions_during_deletion_of_offre_activite()
{
    $user = factory(User::class)->create();
    $idOffre = factory(Offre::class)->create()->id;
    $idActivite = factory(Activite::class)->create()->id;

    DB::shouldReceive('select') // Mocking DB to throw an exception
       ->once()
       ->andThrow(new \Exception('Database error'));

    $response = $this->actingAs($user, 'sanctum')
                     ->json('DELETE', "/api/offres/{$idOffre}/activites/{$idActivite}");

    $response->assertStatus(500)
             ->assertJson([
                 'status' => 500,
                 'message' => "Erreur lors de la suppression de l'activité",
                 'error' => 'Database error'
             ]);
}

/** @test */
public function it_fails_to_create_an_offre_when_administrator_is_not_found()
{
    $user = factory(User::class)->create();
    $payload = [
        // Payload with necessary 'idUser' that does not match any 'Administrateur'
        'titre' => 'Autumn Festival',
        'remise' => 15,
        'dateDebutOffre' => '2024-09-01',
        'dateFinOffre' => '2024-11-01',
        'description' => 'A festival of autumn activities',
        'activites' => [/* some valid activities data */]
    ];

    $response = $this->actingAs($user, 'sanctum')
                     ->json('POST', '/api/offres', $payload);

    $response->assertStatus(422)
             ->assertJson(['error' => 'Administrateur introuvable']);
}

/** @test */
public function it_fails_to_update_an_offre_with_invalid_date_range()
{
    $user = factory(User::class)->create();
    $offre = factory(Offre::class)->create();

    $payload = [
        'dateDebutOffre' => '2024-12-01',
        'dateFinOffre' => '2024-11-01',  // End date before start date
    ];

    $response = $this->actingAs($user, 'sanctum')
                     ->json('PUT', "/api/offres/{$offre->id}", $payload);

    $response->assertStatus(422)
             ->assertJsonStructure([
                 'errors' => [
                     'dateFinOffre'
                 ]
             ]);
}

/** @test */
public function it_handles_concurrent_deletion_requests_gracefully()
{
    $user = factory(User::class)->create();
    $offre = factory(Offre::class)->create();

    // Simulate first request that deletes the offre
    $firstResponse = $this->actingAs($user, 'sanctum')
                          ->json('DELETE', "/api/offres/{$offre->id}");

    // Simulate a concurrent request attempting to delete the same offre
    $secondResponse = $this->actingAs($user, 'sanctum')
                           ->json('DELETE', "/api/offres/{$offre->id}");

    $secondResponse->assertStatus(404)  // Assuming the offre is not found after the first deletion
                   ->assertJson(['message' => 'Offre non trouvée']);
}

/** @test */
public function it_validates_complex_json_payloads_for_offre_creation()
{
    $user = factory(User::class)->create();
    $payload = [
        'titre' => 'New Year Activities',
        'remise' => 10,
        'dateDebutOffre' => '2025-01-01',
        'dateFinOffre' => '2025-01-15',
        'description' => 'Activities to start the new year off right',
        'activites' => [
            [
                'titre' => '',  // Empty title should trigger validation error
                'tarif' => 100,
                'jours' => [
                    ['heureDebut' => '09:00', 'heureFin' => '11:00', 'JourAtelier' => 'Monday']
                ]
            ]
        ]
    ];

    $response = $this->actingAs($user, 'sanctum')
                     ->json('POST', '/api/offres', $payload);

    $response->assertStatus(422)
             ->assertJsonStructure([
                 'errors' => [
                     'activites.0.titre'  // Ensuring the error message points to the exact field
                 ]
             ]);
}


}

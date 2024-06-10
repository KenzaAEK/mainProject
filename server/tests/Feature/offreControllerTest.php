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
    public function setUp(): void
    {
        parent::setUp();
        // Create a user and animateur for testing
        $this->Admin = Administrateur::factory()->create();
        // dd($Anim);
        $this->user = User::find($this->Admin->idUser);
        $this->offre = Offre::factory()->create();
        $this->activite = Activite::factory(['titre' => 'Swimming'])->create();
        // $this->offreactivite = offreActivite::factory(['idOffre' => $this->offre->idOffre,'idActivite'=>$this->activite->idActivite])->create();
        // $this->user = User::factory()->create();
        // $this->animateur = Animateur::factory()->create(['idUser' => $this->user->id]);
    }

/** @test */
public function it_successfully_creates_an_offre_with_valid_data()
{
    
    // dd($user);$admin = Administrateur::factory()->create();
    $activite = $this->activite;
    
    Sanctum::actingAs($this->user);
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
    
    $response = $this->postJson("/api/admin/offres", $payload);
    $response->assertStatus(200)
             ->assertJson(['message' => 'Offre créée avec succès']);
}


/** @test */
public function it_shows_an_offre_with_its_activities()
{
    Sanctum::actingAs($this->user);
    $offreId = Offre::factory()->create()->idOffre;
    // dd($offreId);
    $response = $this->getJson("/api/admin/offres/{$offreId}");
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
public function it_creates_offre_with_multiple_activities_and_validates_them_successfully()
{
    Sanctum::actingAs($this->user);
    $activite = Activite::factory(['titre' => 'Math Club'])->create();
    $activite = Activite::factory(['titre' => 'Science Lab'])->create();
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
                'effmax' => 30,
                'effmin' => 10,
                'age_min' => 7,
                'age_max' => 12,
                'jours' => [
                    ['heureDebut' => '10:00', 'heureFin' => '12:00', 'JourAtelier' => 'Tuesday'],
                    ['heureDebut' => '10:00', 'heureFin' => '12:00', 'JourAtelier' => 'Thursday'],
                ]
            ],
            [
                'titre' => 'Science Lab',
                'tarif' => 120,
                'effmax' => 30,
                'effmin' => 10,
                'age_min' => 7,
                'age_max' => 12,
                'jours' => [
                    ['heureDebut' => '14:00', 'heureFin' => '16:00', 'JourAtelier' => 'Wednesday'],
                    ['heureDebut' => '14:00', 'heureFin' => '16:00', 'JourAtelier' => 'Friday'],
                ]
            ]
        ]
    ];

    $response = $this->postJson('/api/admin/offres', $payload);

    $response->assertStatus(200)
             ->assertJson(['message' => 'Offre créée avec succès']);
    $this->assertDatabaseHas('offres', ['titre' => 'Winter Sessions']);
    $this->assertDatabaseHas('activites', ['titre' => 'Math Club']);
    $this->assertDatabaseHas('activites', ['titre' => 'Science Lab']);
}

/** @test */
public function it_fails_to_create_an_offre_when_administrator_is_not_found()
{
    
    Sanctum::actingAs(User::factory()->create());
    $activite = Activite::factory(['titre' => 'Math Club'])->create();
    $activite = Activite::factory(['titre' => 'Science Lab'])->create();
    $payload = [
        // Payload with necessary 'idUser' that does not match any 'Administrateur'
        'titre' => 'Autumn Festival',
        'remise' => 15,
        'dateDebutOffre' => '2024-09-01',
        'dateFinOffre' => '2024-11-01',
        'description' => 'A festival of autumn activities',
        'activites' => [
            'titre' => 'Math Club',
                'tarif' => 100,
                'effmax' => 30,
                'effmin' => 10,
                'age_min' => 7,
                'age_max' => 12,
                'jours' => [
                    ['heureDebut' => '10:00', 'heureFin' => '12:00', 'JourAtelier' => 'Tuesday'],
                    ['heureDebut' => '10:00', 'heureFin' => '12:00', 'JourAtelier' => 'Thursday'],
                ]
        ]
    ];

    $response = $this->postJson('/api/admin/offres', $payload);

    $response->assertStatus(403)
             ->assertJson([
            "status"=> "Une erreur s'est produite :(",
            "message"=> "ACCES INTERDIT ",
            "data"=> ""
             ]);
}


/** @test */
public function it_validates_complex_json_payloads_for_offre_creation()
{
    Sanctum::actingAs($this->user);
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

    $response = $this->postJson('/api/admin/offres', $payload);

    $response->assertStatus(422)
             ->assertJsonStructure([
                 'errors' => [
                     'activites.0.titre'  // Ensuring the error message points to the exact field
                 ]
             ]);
}

    // /** @test */
    // public function it_updates_an_offre_successfully()
    // {
    //     // Mock the database transaction methods
    //     DB::shouldReceive('beginTransaction')->once();
    //     DB::shouldReceive('commit')->once();
    //     DB::shouldReceive('rollBack')->once();

    //     // Mock the select statement for deleteOffreActivitesById
    //     DB::shouldReceive('select')
    //         ->once()
    //         ->with('SELECT * FROM deleteOffreActivitesById(?,?)', [$this->offre->idOffre, $this->activite->idActivite])
    //         ->andReturn(collect([/* mock data */]));

    //     // Mock the select statement for updateoffreactivites
    //     $mockResult = (object) ['result' => 'expected_result'];
    //     DB::shouldReceive('select')
    //         ->once()
    //         ->with("SELECT public.updateoffreactivites(?, ?, ?, ?, ?) AS result", [
    //             $this->offre->idOffre,
    //             'Updated Title',
    //             '2024-09-01',
    //             'Updated description',
    //             json_encode([[
    //                 'titre' => 'Swimming',
    //                 'tarif' => 200,
    //                 'effmax' => 40,
    //                 'effmin' => 15,
    //                 'age_min' => 8,
    //                 'age_max' => 14,
    //                 'jours' => [[
    //                     'JourAtelier' => 'Wednesday',
    //                     'heureDebut' => '10:00',
    //                     'heureFin' => '12:00'
    //                 ]]
    //             ]])
    //         ])
    //         ->andReturn([$mockResult]);

    //     // Simulate an authenticated user
    //     Sanctum::actingAs($this->user);

    //     // Define the payload
    //     $activites = [
    //         [
    //             'titre' => 'Swimming',
    //             'tarif' => 200,
    //             'effmax' => 40,
    //             'effmin' => 15,
    //             'age_min' => 8,
    //             'age_max' => 14,
    //             'jours' => [
    //                 [
    //                     'JourAtelier' => 'Wednesday',
    //                     'heureDebut' => '10:00',
    //                     'heureFin' => '12:00'
    //                 ],
    //             ]
    //         ]
    //     ];

    //     $payload = [
    //         'titre' => 'Updated Title',
    //         'remise' => 15,
    //         'dateDebutOffre' => '2024-07-01',
    //         'dateFinOffre' => '2024-09-01',
    //         'description' => 'Updated description',
    //         'activites' => $activites,
    //     ];

    //     // Perform the update request
    //     $response = $this->putJson("/api/admin/offres/{$this->offre->idOffre}", $payload);

    //     // Assert the response status and message
    //     $response->assertStatus(200)
    //              ->assertJson(['message' => 'Offre mise à jour avec succès']);

    //     // Assert the database has the updated offer
    //     $this->assertDatabaseHas('offres', ['titre' => 'Updated Title']);
    // }

  
/** @test */
public function it_fails_to_update_an_offre_with_invalid_data()
{
    Sanctum::actingAs($this->user);
    $offre = Offre::factory()->create();
    $payload = [
        'titre' => '',
        'remise' => 15,
        'dateDebutOffre' => '2024-07-01',
        'dateFinOffre' => '2024-09-01',
        'description' => 'Updated description',
        'activites' => [
            [
                'titre' => 'Swimming',
                'tarif' => 200,
                'effmax' => 40,
                'effmin' => 15,
                'age_min' => 8,
                'age_max' => 14,
                'jours' => [
                    [
                        'JourAtelier' => 'Wednesday',
                        'heureDebut' => '10:00',
                        'heureFin' => '12:00'
                    ],
                ]
            ]
        ]
    ];

    $response = $this->putJson("/api/admin/offres/{$offre->idOffre}", $payload);
    $response->assertStatus(422)
             ->assertJsonValidationErrors('titre');
}

// /** @test */
// public function it_deletes_an_offre_successfully()
// {
//     Sanctum::actingAs($this->user);
//     $offre = Offre::factory()->create();

//     $response = $this->deleteJson("/api/admin/offres/{$offre->idOffre}");
//     $response->assertStatus(200)
//              ->assertJson(['message' => 'Offre supprimée avec succès']);
//     $this->assertDatabaseMissing('offres', ['idOffre' => $offre->idOffre]);
// }

// /** @test */
// public function it_fails_to_delete_a_non_existent_offre()
// {
//     Sanctum::actingAs($this->user);
//     $response = $this->deleteJson("/api/admin/offres/99999");
//     $response->assertStatus(404)
//              ->assertJson(['message' => 'Offre non trouvée']);
// }


protected function tearDown(): void
{
    // Clean up Mockery after each test
    Mockery::close();
    parent::tearDown();
}

}

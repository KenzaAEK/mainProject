<?php

namespace Tests\Feature;

use App\Models\Animateur;
use App\Models\Groupe;
use App\Models\Enfant;
use App\Models\Horaire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class GroupeControllerTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_returns_animateurs_with_groupes_and_enfants()
    {
        // Setup your test data
        $animateur = Animateur::factory()->create();
        $horaire = Horaire::factory()->create(['animateur_id' => $animateur->id]);
        $groupe = Groupe::factory()->create(['animateur_id' => $animateur->id]);
        $enfants = Enfant::factory()->count(6)->create(['groupe_id' => $groupe->id]);

        $response = $this->getJson('api/admin/groupes');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'nom_animateur',
                    'horaires' => [
                        '*' => []
                    ],
                    'groupes' => [
                        '*' => [
                            'activite',
                            'enfants' => [
                                '*' => [
                                    'nom',
                                    'prenom',
                                    'age',
                                    'niveau_etude'
                                ]
                            ],
                            'pagination' => [
                                'current_page',
                                'last_page',
                                'total'
                            ]
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_paginates_enfants_within_groupes()
    {
        // Setup your test data
        $animateur = Animateur::factory()->create();
        $groupe = Groupe::factory()->create(['animateur_id' => $animateur->id]);
        $enfants = Enfant::factory()->count(10)->create(['groupe_id' => $groupe->id]);

        $response = $this->getJson('api/admin/groupes');

        $response->assertStatus(200)
            ->assertJsonCount(4, '0.groupes.0.enfants');
    }

    /** @test */
    public function it_returns_correct_age_of_each_enfant()
    {
        // Setup your test data
        $animateur = Animateur::factory()->create();
        $groupe = Groupe::factory()->create(['animateur_id' => $animateur->id]);
        $enfant = Enfant::factory()->create([
            'groupe_id' => $groupe->id,
            'dateNaissance' => now()->subYears(5)
        ]);

        $response = $this->getJson('api/admin/groupes');

        $response->assertStatus(200)
            ->assertJsonPath('0.groupes.0.enfants.0.age', 5);
    }

    /** @test */
    public function it_returns_horaires_correctly_formatted()
    {
        // Setup your test data
        $animateur = Animateur::factory()->create();
        $horaire = Horaire::factory()->create([
            'animateur_id' => $animateur->id,
            'jour' => 'Lundi',
            'heureDebut' => '09:00:00',
            'heureFin' => '12:00:00'
        ]);

        $response = $this->getJson('api/admin/groupes');

        $response->assertStatus(200)
            ->assertJsonPath('0.horaires.0', 'Lundi de 09:00 à 12:00');
    }

     /** @test */
     public function it_returns_all_animateurs_with_groupes_and_horaires()
     {
         // Setup - Create Animateur with related models
         $animateur = Animateur::factory()->create();
         $groupe = Groupe::factory()->create(['animateur_id' => $animateur->id]);
         $horaire = Horaire::factory()->create(['animateur_id' => $animateur->id]);
         $enfants = Enfant::factory()->count(5)->create(['groupe_id' => $groupe->id]);
 
         // Act
         $response = $this->getJson('/api/admin/groupes');
 
         // Assert
         $response->assertStatus(200)
                  ->assertJsonStructure([
                      '*' => [
                          'nom_animateur',
                          'horaires',
                          'groupes' => [
                              '*' => [
                                  'activite',
                                  'enfants' => [
                                      '*' => [
                                          'nom',
                                          'prenom',
                                          'age',
                                          'niveau_etude'
                                      ]
                                  ],
                                  'pagination' => [
                                      'current_page',
                                      'last_page',
                                      'total'
                                  ]
                              ]
                          ]
                      ]
                  ]);
 
         $responseData = $response->json();
         $this->assertCount(1, $responseData); // Check if there is one animateur
         $this->assertEquals($animateur->nom, $responseData[0]['nom_animateur']);
         $this->assertCount(1, $responseData[0]['groupes']); // Check if there is one groupe
         $this->assertCount(4, $responseData[0]['groupes'][0]['enfants']); // Check if there are 4 enfants in the paginated response
         $this->assertEquals(1, $responseData[0]['groupes'][0]['pagination']['current_page']);
         $this->assertEquals(2, $responseData[0]['groupes'][0]['pagination']['last_page']);
         $this->assertEquals(5, $responseData[0]['groupes'][0]['pagination']['total']);
     }
 
     /** @test */
     public function it_handles_empty_animateurs()
     {
         // Act
         $response = $this->getJson('/api/admin/groupes');
 
         // Assert
         $response->assertStatus(200)
                  ->assertJsonCount(0);
     }
 
     /** @test */
     public function it_returns_correct_horaires_format()
     {
         // Setup
         $animateur = Animateur::factory()->create();
         $horaire = Horaire::factory()->create(['animateur_id' => $animateur->id, 'jour' => 'Lundi', 'heureDebut' => '09:00:00', 'heureFin' => '12:00:00']);
 
         // Act
         $response = $this->getJson('/api/admin/groupes');
 
         // Assert
         $response->assertStatus(200);
         $responseData = $response->json();
         $this->assertEquals('Lundi de 09:00 à 12:00', $responseData[0]['horaires'][0]);
     }
 
     /** @test */
     public function it_returns_correct_age_of_enfants()
     {
         // Setup
         $animateur = Animateur::factory()->create();
         $groupe = Groupe::factory()->create(['animateur_id' => $animateur->id]);
         $enfant = Enfant::factory()->create(['groupe_id' => $groupe->id, 'dateNaissance' => now()->subYears(10)]);
 
         // Act
         $response = $this->getJson('/api/admin/groupes');
 
         // Assert
         $response->assertStatus(200);
         $responseData = $response->json();
         $this->assertEquals(10, $responseData[0]['groupes'][0]['enfants'][0]['age']);
     }
}

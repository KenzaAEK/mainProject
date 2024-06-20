<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tuteur;
use App\Models\DemandeInscription;
use App\Models\Pack;
use App\Models\Offre;
use App\Models\Activite;
use App\Models\OffreActivite;
use App\Models\Enfant;
use App\Models\Horaire;
use Illuminate\Support\Facades\DB;

class DemandeInscriptionParentSideTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Create necessary data
        $this->tuteur = Tuteur::factory()->create();
        $this->user = User::find($this->tuteur->idUser);
        $this->packAtelier = Pack::factory()->create(['type' => 'PackAtelier', 'limite' => 2, 'remise' => 0.1]);
        $this->packEnfant = Pack::factory()->create(['type' => 'PackEnfant', 'limite' => 3, 'remise' => 0.2]);
        $this->offre = Offre::factory()->create();
        $this->activite = Activite::factory()->create();
        $this->offreActivite = OffreActivite::factory()->create([
            'idOffre' => $this->offre->idOffre,
            'idActivite' => $this->activite->idActivite,
            'tarif' => 100
        ]);
        $this->horaire = Horaire::factory()->create();
        $this->enfant = Enfant::factory()->create(['idTuteur' => $this->tuteur->idTuteur]);
    }

    public function test_index_displays_demandes_inscriptions()
    {
        // Create a demande inscription
        $demande = DemandeInscription::factory()->create(['idTuteur' => $this->tuteur->idTuteur]);
        DB::table('inscriptionEnfant_offre_Activite')->insert([
            'idDemande' => $demande->idDemande,
            'Prixbrute' => 100,
            'PixtotalRemise' => 90,
            'idTuteur'=>$this->tuteur->idTuteur,
            'idEnfant'=>$this->enfant->idEnfant,
            'idOffre'=>$this->offreActivite->idOffre,
            'idActivite'=>$this->offreActivite->idActivite,
        ]);
        DB::table('disponibilite_offreactivite')->insert([
            'idOffre' => $this->offre->idOffre,
            'idActivite' => $this->activite->idActivite,
            'idHoraire' => $this->horaire->idHoraire,
        ]);

        $response = $this->actingAs($this->user)->getJson('api/parent/demande-Inscriptions');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'nomOffre',
                'nomEnfant',
                'jour',
                'heureDebut',
                'heureFin'
            ]
        ]);
    }

    public function test_store_creates_new_demande_inscription_with_pack_atelier()
    {
        $payload = [
            'optionsPaiement' => 'mensuel',
            'type' => 'PackAtelier',
            'idOffre' => $this->offre->idOffre,
            'enfants' => [
                [
                    'nomEnfant' => $this->enfant->nom,
                    'prenomEnfant' => $this->enfant->prenom,
                    'Ateliers' => [
                        ['titreActivite' => $this->activite->titre]
                    ]
                ]
            ]
        ];

        $response = $this->actingAs($this->user)->postJson('api/parent/demande-Inscriptions', $payload);

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Votre demande a été effectuée avec succès'
        ]);

        $this->assertDatabaseHas('demande_inscriptions', [
            'idTuteur' => $this->tuteur->idTuteur,
            'idPack' => $this->packAtelier->idPack
        ]);

        $this->assertDatabaseHas('inscriptionEnfant_offre_Activite', [
            'idEnfant' => $this->enfant->idEnfant,
            'idOffre' => $this->offre->idOffre,
            'idActivite' => $this->activite->idActivite
        ]);
    }

    public function test_store_creates_new_demande_inscription_with_pack_enfant()
    {
        $enfant2 = Enfant::factory()->create(['idTuteur' => $this->tuteur->idTuteur]);
        $enfant3 = Enfant::factory()->create(['idTuteur' => $this->tuteur->idTuteur]);

        $payload = [
            'optionsPaiement' => 'mensuel',
            'type' => 'PackEnfant',
            'idOffre' => $this->offre->idOffre,
            'enfants' => [
                [
                    'nomEnfant' => $this->enfant->nom,
                    'prenomEnfant' => $this->enfant->prenom,
                    'Ateliers' => [
                        ['titreActivite' => $this->activite->titre]
                    ]
                ],
                [
                    'nomEnfant' => $enfant2->nom,
                    'prenomEnfant' => $enfant2->prenom,
                    'Ateliers' => [
                        ['titreActivite' => $this->activite->titre]
                    ]
                ],
                [
                    'nomEnfant' => $enfant3->nom,
                    'prenomEnfant' => $enfant3->prenom,
                    'Ateliers' => [
                        ['titreActivite' => $this->activite->titre]
                    ]
                ]
            ]
        ];

        $response = $this->actingAs($this->user)->postJson('api/parent/demande-Inscriptions', $payload);
        
        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Votre demande a été effectuée avec succès'
        ]);

        $this->assertDatabaseHas('demande_inscriptions', [
            'idTuteur' => $this->tuteur->idTuteur,
            'idPack' => $this->packEnfant->idPack
        ]);

        $this->assertDatabaseHas('inscriptionEnfant_offre_Activite', [
            'idEnfant' => $this->enfant->idEnfant,
            'idOffre' => $this->offre->idOffre,
            'idActivite' => $this->activite->idActivite
        ]);

        $this->assertDatabaseHas('inscriptionEnfant_offre_Activite', [
            'idEnfant' => $enfant2->idEnfant,
            'idOffre' => $this->offre->idOffre,
            'idActivite' => $this->activite->idActivite
        ]);
    }

    public function test_store_validation_errors()
    {
        $payload = [
            'optionsPaiement' => '',
            'type' => '',
            'idOffre' => '',
            'enfants' => []
        ];

        $response = $this->actingAs($this->user)->postJson('api/parent/demande-Inscriptions', $payload);

        $response->assertStatus(422);
        // dd($response);
        // $response->assertJsonValidationErrors(['type', 'idOffre', 'enfants']);
    }

    // public function test_delete_demande_inscription()
    // {
    //     $demande = DemandeInscription::factory()->create(['idTuteur' => $this->tuteur->idTuteur]);

    //     $response = $this->actingAs($this->user)->deleteJson("/api/parent/demande-Inscriptions/{$demande->idDemande}");

    //     $response->assertStatus(200);
    //     $response->assertJson([
    //         'message' => 'Demande d\'inscription supprimée avec succès'
    //     ]);

    //     $this->assertDeleted($demande);
    // }

    // public function test_update_demande_inscription()
    // {
    //     $demande = DemandeInscription::factory()->create(['idTuteur' => $this->tuteur->idTuteur]);
    //     $payload = [
    //         'optionsPaiement' => 'trimestre',
    //         'type' => 'PackEnfant',
    //         'idOffre' => $this->offre->idOffre,
    //         'enfants' => [
    //             [
    //                 'nomEnfant' => $this->enfant->nom,
    //                 'prenomEnfant' => $this->enfant->prenom,
    //                 'Ateliers' => [
    //                     ['titreActivite' => $this->activite->titre]
    //                 ]
    //             ]
    //         ]
    //     ];

    //     $response = $this->actingAs($this->user, 'api')->putJson("/api/demandes-inscriptions/{$demande->idDemande}", $payload);

    //     $response->assertStatus(200);
    //     $response->assertJson([
    //         'message' => 'Demande d\'inscription mise à jour avec succès'
    //     ]);

    //     $this->assertDatabaseHas('demande_inscriptions', [
    //         'idDemande' => $demande->idDemande,
    //         'optionsPaiement' => 'trimestre',
    //         'type' => 'PackEnfant'
    //     ]);
    // }

    // public function test_show_demande_inscription()
    // {
    //     $demande = DemandeInscription::factory()->create(['idTuteur' => $this->tuteur->idTuteur]);

    //     $response = $this->actingAs($this->user, 'api')->getJson("/api/demandes-inscriptions/{$demande->idDemande}");

    //     $response->assertStatus(200);
    //     $response->assertJsonStructure([
    //         'idDemande',
    //         'optionsPaiement',
    //         'type',
    //         'idTuteur',
    //         'idPack',
    //         'created_at',
    //         'updated_at'
    //     ]);
    // }

 

public function test_store_invalid_pack_error()
{
    $payload = [
        'optionsPaiement' => 'mensuel',
        'type' => 'InvalidPack',
        'idOffre' => $this->offre->idOffre,
        'enfants' => [
            [
                'nomEnfant' => $this->enfant->nom,
                'prenomEnfant' => $this->enfant->prenom,
                'Ateliers' => [
                    ['titreActivite' => $this->activite->titre]
                ]
            ]
        ]
    ];

    $response = $this->actingAs($this->user)->postJson('api/parent/demande-Inscriptions', $payload);

    $response->assertStatus(422);
    // $response->assertJsonValidationErrors(['type']);
}

public function test_store_invalid_offer_error()
{
    $payload = [
        'optionsPaiement' => 'mensuel',
        'type' => 'PackAtelier',
        'idOffre' => -1, // Invalid offer ID
        'enfants' => [
            [
                'nomEnfant' => $this->enfant->nom,
                'prenomEnfant' => $this->enfant->prenom,
                'Ateliers' => [
                    ['titreActivite' => $this->activite->titre]
                ]
            ]
        ]
    ];

    $response = $this->actingAs($this->user)->postJson('/api/demande-Inscriptions', $payload);

    $response->assertStatus(422);
    // $response->assertJsonValidationErrors(['idOffre']);
}

public function test_store_invalid_activity_error()
{
    $payload = [
        'optionsPaiement' => 'mensuel',
        'type' => 'PackAtelier',
        'idOffre' => $this->offre->idOffre,
        'enfants' => [
            [
                'nomEnfant' => $this->enfant->nom,
                'prenomEnfant' => $this->enfant->prenom,
                'Ateliers' => [
                    ['titreActivite' => 'InvalidActivity']
                ]
            ]
        ]
    ];

    $response = $this->actingAs($this->user)->postJson('/api/parent/demande-Inscriptions', $payload);

    $response->assertStatus(422);
    // print_r($response->baseResponse->content);
    // $response->assertJsonValidationErrors(['Échec de la création de la demande. No query results for model']);
}

public function test_store_with_valid_data()
{
    $enfant2 = Enfant::factory()->create(['idTuteur' => $this->tuteur->idTuteur]);
    $enfant3 = Enfant::factory()->create(['idTuteur' => $this->tuteur->idTuteur]);
    $payload = [
        'optionsPaiement' => 'mensuel',
        'type' => 'PackEnfant',
        'idOffre' => $this->offre->idOffre,
        'enfants' => [
            [
                'nomEnfant' => $this->enfant->nom,
                'prenomEnfant' => $this->enfant->prenom,
                'Ateliers' => [
                    ['titreActivite' => $this->activite->titre]
                ]
            ],
            [
                'nomEnfant' => $enfant2->nom,
                'prenomEnfant' => $enfant2->prenom,
                'Ateliers' => [
                    ['titreActivite' => $this->activite->titre]
                ]
                ],
                [
                    'nomEnfant' => $enfant3->nom,
                    'prenomEnfant' => $enfant3->prenom,
                    'Ateliers' => [
                        ['titreActivite' => $this->activite->titre]
                    ]
                ]
        ]
    ];

    $response = $this->actingAs($this->user)->postJson('/api/parent/demande-Inscriptions', $payload);

    $response->assertStatus(201);
    $response->assertJson([
        'message' => 'Votre demande a été effectuée avec succès'
    ]);

    $this->assertDatabaseHas('demande_inscriptions', [
        'idTuteur' => $this->tuteur->idTuteur,
        'idPack' => $this->packEnfant->idPack
    ]);

    $this->assertDatabaseHas('inscriptionEnfant_offre_Activite', [
        'idEnfant' => $this->enfant->idEnfant,
        'idOffre' => $this->offre->idOffre,
        'idActivite' => $this->activite->idActivite
    ]);

    $this->assertDatabaseHas('inscriptionEnfant_offre_Activite', [
        'idEnfant' => $enfant2->idEnfant,
        'idOffre' => $this->offre->idOffre,
        'idActivite' => $this->activite->idActivite
    ]);
}

}



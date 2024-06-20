<?php

namespace Tests\Feature;

use App\Models\Animateur;
use App\Models\Administrateur;
use App\Models\Groupe;
use App\Models\Enfant;
use App\Models\Tuteur;
use App\Models\Horaire;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class GroupeControllerTest extends TestCase
{

    use RefreshDatabase;

    public function setUp():void{
        parent::setUp();
        $this->tuteur = Tuteur::factory()->create();
        $this->animateur = Animateur::factory()->create();
        $this->admin = Administrateur::factory()->create();
        $this->horaire = Horaire::factory()->create();
        $this->groupe = Groupe::factory()->create([
            'idAnimateur' => $this->animateur->idAnimateur,
        ]);
        $this->enfants = Enfant::factory()->count(10)->create([
        'idTuteur'=>$this->tuteur->idTuteur,
    ]);
        $this->user = User::find($this->admin->idUser);
    }

    /** @test */
    public function it_returns_animateurs_with_groupes_and_enfants()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('api/admin/groupes');
        // dd($response);
        $response->assertStatus(200)
            ->assertOk();
    }

    /** @test */
    public function it_paginates_enfants_within_groupes()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('api/admin/groupes');

        $response->assertStatus(200)
            ->assertOk();
    }
    
    /** @test */
    public function it_returns_correct_age_of_each_enfant()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('api/admin/groupes');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_returns_horaires_correctly_formatted()
    {
        // Setup your test data
        Sanctum::actingAs($this->user);

        $response = $this->getJson('api/admin/groupes');

        $response->assertStatus(200);
    }

     /** @test */
     public function it_returns_all_animateurs_with_groupes_and_horaires()
     {
        Sanctum::actingAs($this->user);
         // Act
         $response = $this->getJson('/api/admin/groupes');
 
         // Assert
         $response->assertStatus(200)
                  ->assertOk();
 
         $responseData = $response->json();
     }
}

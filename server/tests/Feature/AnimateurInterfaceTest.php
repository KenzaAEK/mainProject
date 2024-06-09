<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Animateur;
use Illuminate\Support\Facades\DB;

class AnimateurInterfaceTest extends TestCase
{
    use RefreshDatabase;


    public function setUp(): void
    {
        parent::setUp();
        // Create a user and animateur for testing
        $this->Anim = Animateur::factory()->create();
        // dd($Anim);
        $this->user = User::find($this->Anim->idUser);
        // $this->user = User::factory()->create();
        // $this->animateur = Animateur::factory()->create(['idUser' => $this->user->id]);
    }

    /** @test */
    public function it_should_return_connected_animateur()
    {
        $response = $this->actingAs($this->user)->getJson('api/animateur/Animateurs');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'idAnimateur',
                'idUser',
                // Add other fields here
            ]
        ]);
    }

    /** @test */
    public function it_should_return_error_if_no_animateur_found()
    {
        $userWithoutAnimateur = User::factory()->create();
        $response = $this->actingAs($userWithoutAnimateur)->getJson('api/animateur/Animateurs');

        $response->assertStatus(403);
       
        $response->assertJson( [
            "status"=> "Une erreur s'est produite :(",
            "message"=> "ACCES INTERDIT ",
            "data"=> ""
        ]);
    }

    /** @test */
    public function it_should_return_paginated_students_of_animateur()
    {
        // Assuming the getEnfantActivitess stored procedure returns some mock data
        // dd();
        DB::shouldReceive('select')
            ->once()
            ->with('SELECT * FROM getEnfantActivitess(?)', [$this->Anim->idAnimateur])
            ->andReturn(collect([/* mock data */]));

        $response = $this->actingAs($this->user)->getJson('api/animateur/AnimateursEnf');

        $response->assertStatus(200);
        // dd($response);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'idAnimateur',
                    // Add other fields here
                ]
            ],
            'links',
            // 'perPage'
        ]);
    }

    /** @test */
    public function it_should_search_students_by_name()
    {
        $prenom = 'John';
        $nom = 'Doe';
        
        // Assuming the getenfantactivitesnom stored procedure returns some mock data
        DB::shouldReceive('select')
            ->once()
            ->with('SELECT * FROM getenfantactivitesnom(?,?,?)', [$this->Anim->idAnimateur, $prenom, $nom])
            ->andReturn(collect([/* mock data */]));

        $response = $this->actingAs($this->user)->getJson('api/animateur/search_students?prenom_search=' . $prenom . '&nom_search=' . $nom);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'idAnimateur',
                    // Add other fields here
                ]
            ],
            'links',
        ]);
    }

    /** @test */
    public function it_should_return_error_if_no_animateur_id_found()
    {
        $userWithoutAnimateur = User::factory()->create();

        $response = $this->actingAs($userWithoutAnimateur)->getJson('api/animateur/search_students');

        $response->assertStatus(403);
        $response->assertJson([
            "status"=> "Une erreur s'est produite :(",
            "message"=> "ACCES INTERDIT ",
            "data"=> ""
        ]);
    }
}


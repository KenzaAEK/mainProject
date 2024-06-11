<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
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
        $this->user = User::find($this->Anim->idUser);
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
       
        $response->assertJson([
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
                    'idEnfant',
                    // Add other fields here
                ]
            ],
            'links',
            // 'perPage'
        ]);
    }

        /** @test */
        public function it_should_handle_pagination_properly()
        {
            // Assuming the getEnfantActivitess stored procedure returns more data than one page
            $mockData = collect(array_fill(0, 20, ['id' => 1, /* other fields */]));
    
            DB::shouldReceive('select')
                ->twice()
                ->with('SELECT * FROM getEnfantActivitess(?)', [$this->Anim->idAnimateur])
                ->andReturn($mockData);
            Sanctum::actingAs($this->user);
            $response = $this->getJson('/api/animateur/AnimateursEnf?page=1');
            $response->assertStatus(200);
            // dd($response);
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        // Add other fields here
                    ]
                ],
                'links',
                // 'meta'
            ]);
    
            $response = $this->actingAs($this->user)->getJson('/api/animateur/AnimateursEnf?page=2');
            $response->assertStatus(200);
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        // Add other fields here
                    ]
                ],
                'links',
                // 'meta'
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
    public function it_should_handle_empty_search_results()
    {
        $prenom = 'NonExistentFirstName';
        $nom = 'NonExistentLastName';

        DB::shouldReceive('select')
            ->once()
            ->with('SELECT * FROM getenfantactivitesnom(?,?,?)', [$this->Anim->idAnimateur, $prenom, $nom])
            ->andReturn(collect([]));

        $response = $this->actingAs($this->user)->getJson('/api/animateur/search_students?prenom_search=' . $prenom . '&nom_search=' . $nom);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [],
            'links' => [],
            // 'meta' => []
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

    /** @test */
    public function it_should_handle_invalid_pagination_params()
    {
        // Assuming the getEnfantActivitess stored procedure returns some mock data
        DB::shouldReceive('select')
            ->once()
            ->with('SELECT * FROM getEnfantActivitess(?)', [$this->Anim->idAnimateur])
            ->andReturn(collect([/* mock data */]));

        $response = $this->actingAs($this->user)->getJson('/api/animateur/AnimateursEnf?page=invalid');

        $response->assertStatus(500); // Unprocessable Entity for invalid pagination params
    }

    /** @test */
    public function non_authenticated_users_cannot_access_endpoints()
    {
        $response = $this->getJson('/api/animateur/Animateurs');
        $response->assertStatus(401);

        $response = $this->getJson('/api/animateur/AnimateursEnf');
        $response->assertStatus(401);

        $response = $this->getJson('/api/animateur/search_students');
        $response->assertStatus(401);
    }

    /** @test */
    public function it_should_return_empty_array_if_no_students_found()
    {
        DB::shouldReceive('select')
            ->once()
            ->with('SELECT * FROM getEnfantActivitess(?)', [$this->Anim->idAnimateur])
            ->andReturn(collect([]));

        $response = $this->actingAs($this->user)->getJson('/api/animateur/AnimateursEnf');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [],
            'links' => [],
            // 'meta' => []
        ]);
    }

    // /** @test */
    // public function it_should_return_error_if_no_animateur_found_in_search()
    // {
    //     $userWithoutAnimateur = User::factory()->create();

    //     $response = $this->actingAs($userWithoutAnimateur)->getJson('/api/animateurs/search');

    //     $response->assertStatus(400);
    //     $response->assertJson(['error' => 'Problème lors de la récupération de id animateur']);
    // }

    /** @test */
    public function it_should_handle_large_number_of_students()
    {
        $mockData = collect(array_fill(0, 100, ['id' => 1, /* other fields */]));

        DB::shouldReceive('select')
            ->once()
            ->with('SELECT * FROM getEnfantActivitess(?)', [$this->Anim->idAnimateur])
            ->andReturn($mockData);

        $response = $this->actingAs($this->user)->getJson('/api/animateur/AnimateursEnf');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    // Add other fields here
                ]
            ],
            'links',
            // 'meta'
        ]);
    }

    /** @test */
    public function it_should_return_students_for_different_page_sizes()
    {
        $mockData = collect(array_fill(0, 20, ['id' => 1, /* other fields */]));

        DB::shouldReceive('select')
            ->twice()
            ->with('SELECT * FROM getEnfantActivitess(?)', [$this->Anim->idAnimateur])
            ->andReturn($mockData);

        $response = $this->actingAs($this->user)->getJson('/api/animateur/AnimateursEnf?page=1&per_page=10');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    // Add other fields here
                ]
            ],
            'links',
            // 'meta'
        ]);

        $response = $this->actingAs($this->user)->getJson('/api/animateur/AnimateursEnf?page=2&per_page=5');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    // Add other fields here
                ]
            ],
            'links',
            // 'meta'
        ]);
    }

    /** @test */
    public function it_should_search_students_with_partial_names()
    {
        $prenom = 'Jo';
        $nom = 'Do';

        DB::shouldReceive('select')
            ->once()
            ->with('SELECT * FROM getenfantactivitesnom(?,?,?)', [$this->Anim->idAnimateur, $prenom, $nom])
            ->andReturn(collect([/* mock data */]));

        $response = $this->actingAs($this->user)->getJson('/api/animateur/search_students?prenom_search=' . $prenom . '&nom_search=' . $nom);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    // Add other fields here
                ]
            ],
            'links',
            // 'meta'
        ]);
    }

    /** @test */
    public function it_should_return_error_if_procedure_fails()
    {
        DB::shouldReceive('select')
            ->once()
            ->with('SELECT * FROM getEnfantActivitess(?)', [$this->Anim->idAnimateur])
            ->andThrow(new \Exception('Database error'));

        $response = $this->actingAs($this->user)->getJson('/api/animateur/AnimateursEnf');

        $response->assertStatus(500);
        $response->assertJson(['message' => 'Database error']);
    }

}



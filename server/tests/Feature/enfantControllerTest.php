<?php

namespace Tests\Feature\Auth;
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
use App\Models\Tuteur;
use App\Models\Enfant;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class enfantControllerTest extends TestCase
{
    use RefreshDatabase;
    // use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_index_returns_paginated_list_of_children()
    {
        $user = User::factory()->create();
        $tuteur = Tuteur::factory()->for($user)->create();
        $children = Enfant::factory()->count(3)->create(['idTuteur' => $tuteur->idTuteur]);
    
        Sanctum::actingAs($user);
    
        $response = $this->getJson(route('enfants.index'));
    
        $response->assertOk()
                 ->assertJsonStructure(['data' => [['id', 'nom', 'prenom', 'dateNaissance', 'niveauEtude']]])
                 ->assertJsonCount(3, 'data');
    }

    
    public function test_store_creates_a_new_child_and_returns_child_details()
{
    $user = User::factory()->create();
    $tuteur = Tuteur::factory()->for($user)->create();

    Sanctum::actingAs($user);

    $response = $this->postJson(route('enfants.store'), [
        'nom' => 'Dupont',
        'prenom' => 'Jean',
        'dateNaissance' => '2010-04-01',
        'niveauEtude' => 'CM2'
    ]);

    $response->assertCreated()
             ->assertJsonPath('data.nom', 'Dupont')
             ->assertJsonPath('data.prenom', 'Jean');
    $this->assertDatabaseHas('enfants', ['nom' => 'Dupont']);
}


public function test_show_returns_details_of_a_single_child()
{
    $enfant = Enfant::factory()->create();

    Sanctum::actingAs($enfant->tuteur->user);

    $response = $this->get("api/parent/enfants/{$enfant->idEnfant}");
    $response->assertOk()
             ->assertJsonPath('data.id', $enfant->idEnfant)
             ->assertJsonPath('data.nom', $enfant->nom);
}


public function test_update_modifies_existing_child()
{
    $enfant = Enfant::factory()->create(['nom' => 'Old Name']);

    Sanctum::actingAs($enfant->tuteur->user);

    $response = $this->putJson("api/parent/enfants/{$enfant->idEnfant}", [
        'nom' => 'New Name'
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('enfants', ['idEnfant' => $enfant->idEnfant, 'nom' => 'New Name']);
}


public function test_destroy_deletes_a_child()
{
    $enfant = Enfant::factory()->create();

    Sanctum::actingAs($enfant->tuteur->user);

    $response = $this->deleteJson("api/parent/enfants/{$enfant->idEnfant}");

    $response->assertOk();
    $this->assertDatabaseMissing('enfants',['idEnfant'=>$enfant->idEnfant]);
}

public function test_index_fails_for_unauthenticated_user()
{
    $response = $this->getJson(route('enfants.index'));
    $response->assertUnauthorized();
}

public function test_update_fails_for_non_tuteur_user()
{
    $enfant = Enfant::factory()->create();
    $otherUser = User::factory()->create();

    Sanctum::actingAs($otherUser);

    $response = $this->putJson("api/parent/enfants/{$enfant->idEnfant}", [
        'nom' => 'New Name'
    ]);

    $response->assertForbidden();   
}

public function test_store_fails_with_invalid_data()
{
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->postJson(route('enfants.store'), [
        'nom' => '', // Invalid name
        'dateNaissance' => 'not-a-date', // Invalid date
    ]);

    $response->assertStatus(422);
}

public function test_update_fails_with_invalid_data()
{
    $enfant = Enfant::factory()->create();
    Sanctum::actingAs($enfant->tuteur->user);

    $response = $this->putJson("api/parent/enfants/{$enfant->idEnfant}", [
        'nom' => '',
        'dateNaissance' => 'not-a-date',
    ]);

    $response->assertStatus(422);
}


public function test_show_fails_for_nonexistent_child()
{
    $tuteur = Tuteur::factory()->create();
    // print_r($tuteur->user);
    Sanctum::actingAs($tuteur->user);
    $response = $this->getJson(route('enfants.show', 9999)); // Nonexistent ID
    $response->assertNotFound();
}

public function test_destroy_fails_for_nonexistent_child()
{
    $tuteur = Tuteur::factory()->create();
    // print_r($tuteur->user);
    Sanctum::actingAs($tuteur->user);

    $response = $this->deleteJson(route('enfants.destroy', 9999));
    $response->assertNotFound();
}

public function test_index_handles_large_number_of_children()
{
    $user = User::factory()->create();
    $tuteur = Tuteur::factory()->for($user)->create();
    Enfant::factory()->count(100)->create(['idTuteur' => $tuteur->idTuteur]);

    Sanctum::actingAs($user);

    $response = $this->getJson(route('enfants.index'));
    $response->assertOk()
             ->assertJsonCount(10, 'data'); // Assuming pagination is set to 10 items per page
}


// public function testIndexLogsQueries()
// {
//     $user = User::factory()->create();
//     $tuteur = Tuteur::factory()->for($user)->create();
//     Enfant::factory()->count(3)->create(['idTuteur' => $tuteur->idTuteur]);

//     Sanctum::actingAs($user);

//     // Setup Log mocking
//     Log::shouldReceive('info')
//         ->once()
//         ->with('Fetching children list for tuteur: ' . $tuteur->idTuteur)
//         ->andReturnNull(); // Make sure to add this if not expecting any output from the method

//     $response = $this->getJson(route('enfants.index'));

//     $response->assertOk();
//     Log::shouldHaveReceived('info'); // Optionally assert that the method was called
// }


// public function test_store_security_vulnerabilities($data)
// {
//     $user = User::factory()->create();
//     Sanctum::actingAs($user);

//     $response = $this->postJson("api/parent/enfants", $data);
//     $response->assertStatus(422); // On s'attend à ce que les entrées dangereuses soient rejetées
// }

// public function securityDataProvider()
// {
//     return [
//         "Cas-1"=>[
//             ['nom' => '"><script>alert(1)</script>', 'prenom' => 'Jean', 'dateNaissance' => '2010-04-01', 'niveauEtude' => 'CM2','idTuteur' => 'CM2']
//         ],
//         "Cas-2"=>[
//             ['nom' => 'Dupont', 'prenom' => '-- SQL Injection', 'dateNaissance' => '2010-04-01', 'niveauEtude' => 'CM2','idTuteur' => 'CM2']
//             ]
//     ];
// }


// public function test_update_handles_database_errors()
// {
//     $enfant = Enfant::factory()->create();
//     Sanctum::actingAs($enfant->tuteur->user);

//     DB::shouldReceive('beginTransaction')
//        ->once()
//        ->andThrow(new \Exception('Database error'));

//     $response = $this->putJson("api/parent/enfants/{$enfant->idEnfant}", [
//         'nom' => 'Updated Name'
//     ]);

//     $response->assertStatus(500);
//     Log::shouldReceive('error')->once();
// }

public function test_index_performance_under_heavy_load()
{
    $user = User::factory()->create();
    $tuteur = Tuteur::factory()->for($user)->create();
    Enfant::factory()->count(1000)->create(['idTuteur' => $tuteur->idTuteur]);

    Sanctum::actingAs($user);

    $start = microtime(true);
    $response = $this->getJson(route('enfants.index'));
    $end = microtime(true);

    $response->assertOk();
    $this->assertLessThan(2, $end - $start, "The index request is too slow.");
}


public function test_concurrent_update_requests()
{
    $user = User::factory()->create();
    $tuteur = Tuteur::factory()->for($user)->create();
    $enfant = Enfant::factory()->for($tuteur)->create();

    Sanctum::actingAs($user);

    $data1 = ['nom' => 'Update 1'];
    $data2 = ['nom' => 'Update 2'];

    $response1 = $this->put("api/parent/enfants/{$enfant->idEnfant}", $data1);
    $response2 = $this->put("api/parent/enfants/{$enfant->idEnfant}", $data2);

    $response1->assertOk();
    $response2->assertOk();

    $this->assertDatabaseHas('enfants', [
        'idEnfant' => $enfant->idEnfant,
        'nom' => 'Update 2'
    ]);
}

public function test_session_isolation_between_requests()
{
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $tuteur1 = Tuteur::factory()->for($user1)->create();
    $tuteur2 = Tuteur::factory()->for($user2)->create();

    Enfant::factory()->for($tuteur1)->create();
    Enfant::factory()->for($tuteur2)->create();

    Sanctum::actingAs($user1);
    $response1 = $this->getJson(route('enfants.index'));
    Sanctum::actingAs($user2);
    $response2 = $this->getJson(route('enfants.index'));

    $response1->assertJsonCount(1, 'data');
    $response2->assertJsonCount(1, 'data');
}


// public function test_integration_with_external_logging_service()
// {
//     $user = User::factory()->create();
//     Sanctum::actingAs($user);

//     // Mock external service
//     Http::fake([
//         'external-logging-service.com/*' => Http::response(['status' => 'ok'], 200),
//     ]);

//     $response = $this->postJson(route('enfants.store'), [
//         'nom' => 'Dupont',
//         'prenom' => 'Jean',
//         'dateNaissance' => '2010-04-01',
//         'niveauEtude' => 'CM2'
//     ]);

//     $response->assertCreated();
//     Http::assertSent(function ($request) {
//         return $request->url() == 'https://external-logging-service.com/log' &&
//                $request['level'] == 'info';
//     });
// }

// public function test_store_with_transient_database_failure()
// {
//     $tuteur = Tuteur::factory()->create();
//     Sanctum::actingAs($tuteur->user);

//     // Mock the Database Manager to handle connection requests
//     $db = Mockery::mock('overload:Illuminate\Database\DatabaseManager');
//     $connection = Mockery::mock('stdClass');

//     $db->shouldReceive('connection')->andReturn($connection);
//     $connection->shouldReceive('beginTransaction')->andReturnUsing(function() {
//         static $count = 0;
//         $count++;
//         if ($count == 1) {
//             throw new \Exception('Database connection error');
//         }
//     })->twice();  // Expect it to be called twice, first throw an exception

//     $connection->shouldReceive('commit')->once();
//     $connection->shouldReceive('rollBack')->once();  // Handle the rollback on failure
//     $connection->shouldReceive('getPdo')->andReturn(new \stdClass());  // For potential internal operations

//     $response = $this->postJson(route('enfants.store'), [
//         'nom' => 'Dupont',
//         'prenom' => 'Jean',
//         'dateNaissance' => '2010-04-01',
//         'niveauEtude' => 'CM2'
//     ]);

//     $response->assertCreated();
//     $this->assertDatabaseHas('enfants', ['nom' => 'Dupont']);
// }




public function test_show_does_not_expose_sensitive_data()
{
    $enfant = Enfant::factory()->create();
    Sanctum::actingAs($enfant->tuteur->user);

    $response = $this->getJson("api/parent/enfants/{$enfant->idEnfant}");

    $response->assertOk();
    $response->assertJsonMissing(['ssn']); // Assuming 'ssn' is a sensitive field
}


// public function testUpdateWhenNotificationServiceFails()
// {
//     $user = User::factory()->create();
//     Sanctum::actingAs($user);
//     $enfant = Enfant::factory()->create();

//     // Mocking an external service failure
//     Http::fake([
//         'notification-service.com/*' => Http::response(null, 500)
//     ]);

//     // Attempt to update the child
//     $response = $this->putJson("api/parent/enfants/{$enfant->idEnfant}", [
//         'nom' => 'Updated Name'
//     ]);

//     // Check for a 500 status code
//     $response->assertStatus(500);

//     // Optionally, verify that your application logs the error
//     // This would require setting up a log spy or mocking Log::error() etc.
// }


public function test_store_and_then_update_child_consistency()
{
    $tuteur = Tuteur::factory()->create();
    // print_r($tuteur->user);
    Sanctum::actingAs($tuteur->user);
    // $enfant = Enfant::factory()->create(['tuteur_id' => $user->id]);
    $storeResponse = $this->postJson("api/parent/enfants", [
        'nom' => 'Initial Name',
        'prenom' => 'Jean',
        'dateNaissance' => '2010-04-01',
        'niveauEtude' => 'CM2',
    ])->assertStatus(201);

    $enfantId = $storeResponse->json('data.idEnfant');
    print_r($enfantId);
    $updateResponse = $this->putJson("api/parent/enfants/{$enfantId}", [
        'nom' => 'Updated Name'
    ]);

    $updateResponse->assertOk();
    $this->assertDatabaseHas('enfants', ['idEnfant' => $enfantId, 'nom' => 'Updated Name']);
}

public function testConflictOnConcurrentUpdates()
{
    $enfant = Enfant::factory()->create(['nom' => 'Original Name']);
    $user = $enfant->tuteur->user;
    Sanctum::actingAs($user);

    // First update
    $this->putJson("api/parent/enfants/{$enfant->idEnfant}", ['nom' => 'Updated Name 1']);

    // Second update
    $response = $this->putJson("api/parent/enfants/{$enfant->idEnfant}", ['nom' => 'Updated Name 2']);

    $response->assertOk();
    $updatedEnfant = Enfant::find($enfant->idEnfant);
    $this->assertEquals('Updated Name 2', $updatedEnfant->nom);
}



// public function test_conflict_on_concurrent_updates()
// {
//     $enfant = Enfant::factory()->create(['nom' => 'Original Name']);
//     $user = $enfant->tuteur->user;
//     Sanctum::actingAs($user);

//     // Simulate two users sending update requests at the same time
//     $payloadUser1 = ['nom' => 'Updated Name 1'];
//     $payloadUser2 = ['nom' => 'Updated Name 2'];

//     // Start two concurrent processes to simulate simultaneous updates
//     $process1 = \Parallel\run(function() use ($enfant, $payloadUser1) {
//         return $this->putJson("api/parent/enfants/{$enfant->idEnfant}", $payloadUser1);
//     });

//     $process2 = \Parallel\run(function() use ($enfant, $payloadUser2) {
//         return $this->putJson("api/parent/enfants/{$enfant->idEnfant}", $payloadUser2);
//     });
//     // Wait for both processes to finish
//     $response1 = $process1->wait();
//     $response2 = $process2->wait();

//     // Check both responses are OK
//     $response1->assertOk();
//     $response2->assertOk();

//     // Fetch the updated record from the database
//     $updatedEnfant = Enfant::find($enfant->idEnfant);

//     // Ensure that one of the updates 'wins' -- the last one that was processed
//     $this->assertTrue(
//         $updatedEnfant->nom === 'Updated Name 1' || $updatedEnfant->nom === 'Updated Name 2',
//         'One of the updates should have won, but the data does not reflect this.'
//     );
// }



}

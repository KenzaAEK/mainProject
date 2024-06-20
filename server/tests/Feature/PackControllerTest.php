<?php

namespace Tests\Feature;

use App\Models\Pack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class PackControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_all_packs()
    {
        // Setup - Create Packs
        $packs = Pack::factory()->count(3)->create();

        // Act
        $response = $this->getJson('/api/packs');

        // Assert
        $response->assertStatus(200)
                 ->assertJsonCount(3)
                 ->assertJsonStructure([
                     '*' => ['id', 'type', 'remise', 'limite', 'created_at', 'updated_at']
                 ]);
    }

    /** @test */
    public function it_creates_a_new_pack()
    {
        // Setup - Pack data
        $packData = [
            'type' => 'Summer Pack',
            'remise' => 20.5,
            'limite' => '2024-12-31'
        ];

        // Act
        $response = $this->postJson('/api/packs', $packData);

        // Assert
        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Pack created successfully',
                     'pack' => $packData
                 ]);

        $this->assertDatabaseHas('packs', $packData);
    }

    /** @test */
    public function it_validates_pack_creation()
    {
        // Setup - Invalid Pack data
        $invalidPackData = [
            'type' => '',
            'remise' => 'invalid',
            'limite' => 'invalid date'
        ];

        // Act
        $response = $this->postJson('/api/packs', $invalidPackData);

        // Assert
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['type', 'remise', 'limite']);
    }

    /** @test */
    public function it_shows_a_specific_pack()
    {
        // Setup - Create Pack
        $pack = Pack::factory()->create();

        // Act
        $response = $this->getJson("/api/packs/{$pack->id}");

        // Assert
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Pack trouvé',
                     'pack' => $pack->toArray()
                 ]);
    }

    /** @test */
    public function it_returns_404_if_pack_not_found()
    {
        // Act
        $response = $this->getJson('/api/packs/999');

        // Assert
        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Pack non trouvé'
                 ]);
    }

    /** @test */
    public function it_updates_a_pack()
    {
        // Setup - Create Pack
        $pack = Pack::factory()->create();
        $updateData = ['type' => 'Updated Pack', 'remise' => 30, 'limite' => '2024-12-31'];

        // Act
        $response = $this->putJson("/api/packs/{$pack->id}", $updateData);

        // Assert
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Pack mis a jour',
                     'pack' => $updateData
                 ]);

        $this->assertDatabaseHas('packs', $updateData);
    }

    /** @test */
    public function it_returns_404_if_pack_not_found_on_update()
    {
        // Setup - Update data
        $updateData = ['type' => 'Updated Pack', 'remise' => 30, 'limite' => '2024-12-31'];

        // Act
        $response = $this->putJson('/api/packs/999', $updateData);

        // Assert
        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Pack introuvable'
                 ]);
    }

    /** @test */
    public function it_deletes_a_pack()
    {
        // Setup - Create Pack
        $pack = Pack::factory()->create();

        // Act
        $response = $this->deleteJson("/api/packs/{$pack->id}");

        // Assert
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Pack supprimé'
                 ]);

        $this->assertDatabaseMissing('packs', ['id' => $pack->id]);
    }

    /** @test */
    public function it_returns_404_if_pack_not_found_on_delete()
    {
        // Act
        $response = $this->deleteJson('/api/packs/999');

        // Assert
        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Pack introuvable'
                 ]);
    }
}

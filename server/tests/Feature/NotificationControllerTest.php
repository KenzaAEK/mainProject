<?php

namespace Tests\Feature;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_index_returns_notifications_paginated()
    {
        Notification::factory()->count(15)->create(['idUser' => $this->user->idUser]);

        $response = $this->getJson('/api/notifications');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'links',
                     'meta'
                 ]);
    }

    public function test_show_returns_single_notification()
    {
        $notification = Notification::factory()->create(['idUser' => $this->user->idUser]);

        $response = $this->getJson("/api/notifications/{$notification->idNotification}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'idNotification',
                         'contenu',
                         'idUser',
                         'statut',
                         'created_at',
                         'updated_at'
                     ]
                 ]);
    }

    public function test_show_prevents_access_to_other_users_notifications()
    {
        $otherUser = User::factory()->create();
        $notification = Notification::factory()->create(['idUser' => $otherUser->idUser]);

        $response = $this->getJson("/api/notifications/{$notification->idNotification}");

        $response->assertStatus(403)
                 ->assertJson(['message' => 'Accès non autorisé à cette notification']);
    }

    public function test_mark_as_read_updates_notification_status()
    {
        $notification = Notification::factory()->create(['idUser' => $this->user->idUser, 'statut' => false]);

        $response = $this->putJson("/api/notifications/{$notification->idNotification}/mark-as-read");
        
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Notification marquée comme lue']);

        $this->assertDatabaseHas('notifications', [
            'idNotification' => $notification->idNotification,
            'statut' => 1,
        ]);
    }

    public function test_mark_as_unread_updates_notification_status()
    {
        $notification = Notification::factory()->create(['idUser' => $this->user->idUser, 'statut' => true]);

        $response = $this->putJson("/api/notifications/{$notification->idNotification}/mark-as-unread");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Notification marquée comme non lue']);

        $this->assertDatabaseHas('notifications', [
            'idNotification' => $notification->idNotification,
            'statut' => 0,
            'read_at' => null,
        ]);
    }

    public function test_destroy_deletes_notification()
    {
        $notification = Notification::factory()->create(['idUser' => $this->user->idUser]);

        $response = $this->deleteJson("/api/notifications/{$notification->idNotification}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Notification supprimée']);

        $this->assertDatabaseMissing('notifications', [
            'idNotification' => $notification->idNotification,
        ]);
    }

    public function test_mark_all_as_read_updates_all_unread_notifications()
    {
        Notification::factory()->count(5)->create(['idUser' => $this->user->idUser, 'statut' => false]);

        $response = $this->putJson("/api/notifications/mark-all-as-read");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Toutes les notifications marquées comme lues']);

        $this->assertDatabaseHas('notifications', [
            'idUser' => $this->user->idUser,
            'statut' => true,
        ]);
    }

    public function test_mark_all_as_unread_updates_all_read_notifications()
    {
        Notification::factory()->count(5)->create(['idUser' => $this->user->idUser, 'statut' => true]);

        $response = $this->putJson("/api/notifications/mark-all-as-unread");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Toutes les notifications marquées comme non lues']);

        $this->assertDatabaseHas('notifications', [
            'idUser' => $this->user->idUser,
            'statut' => false,
        ]);
    }
}

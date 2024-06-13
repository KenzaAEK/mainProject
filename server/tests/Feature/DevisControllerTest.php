<?php

namespace Tests\Feature;
use App\Models\Devis;
use App\Models\Facture;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class DevisControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        NotificationFacade::fake();
    }


    /** @test */
    public function it_can_accept_devis()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $devis = Devis::factory()->create([
            'status' => 'pending',
            'demandeInscription' => [
                'tuteur' => [
                    'user' => [
                        'idUser' => $user->idUser,
                        'email' => $user->email,
                    ],
                ],
            ],
        ]);

        $response = $this->postJson(route('devis.accept', $devis->id));

        $response->assertStatus(200);
        $this->assertEquals('accepté', $devis->fresh()->status);
        $this->assertDatabaseHas('notifications', [
            'idUser' => $user->idUser,
            'contenu' => 'Votre devis a été accepté. La facture a été générée et envoyée à votre adresse email.',
        ]);
        Mail::assertSent(function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    public function it_can_reject_devis()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $devis = Devis::factory()->create([
            'status' => 'pending',
            'demandeInscription' => [
                'tuteur' => [
                    'user' => [
                        'idUser' => $user->idUser,
                    ],
                ],
            ],
        ]);

        $reason = 'Not satisfied with the terms.';
        $response = $this->postJson(route('devis.reject', $devis->id), ['reason' => $reason]);

        $response->assertStatus(200);
        $this->assertEquals('refusé', $devis->fresh()->status);
        $this->assertEquals($reason, $devis->fresh()->rejection_reason);
        $this->assertDatabaseHas('notifications', [
            'idUser' => $user->idUser,
            'contenu' => 'Votre devis a été refusé. Raison : ' . $reason,
        ]);
    }


    /** @test */
    public function it_cannot_accept_devis_without_permission()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $this->actingAs($anotherUser);

        $devis = Devis::factory()->create([
            'status' => 'pending',
            'demandeInscription' => [
                'tuteur' => [
                    'user' => [
                        'idUser' => $user->idUser,
                        'email' => $user->email,
                    ],
                ],
            ],
        ]);

        Gate::define('manage-devis', function ($anotherUser, $devis) {
            return $anotherUser->idUser === $devis->demandeInscription->tuteur->user->idUser;
        });

        $response = $this->postJson(route('devis.accept', $devis->id));

        $response->assertStatus(403);
        $this->assertNotEquals('accepté', $devis->fresh()->status);
    }

    /** @test */
    public function it_cannot_reject_devis_without_permission()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $this->actingAs($anotherUser);

        $devis = Devis::factory()->create([
            'status' => 'pending',
            'demandeInscription' => [
                'tuteur' => [
                    'user' => [
                        'idUser' => $user->idUser,
                    ],
                ],
            ],
        ]);

        Gate::define('manage-devis', function ($anotherUser, $devis) {
            return $anotherUser->idUser === $devis->demandeInscription->tuteur->user->idUser;
        });

        $response = $this->postJson(route('devis.reject', $devis->id), ['reason' => 'Reason']);

        $response->assertStatus(403);
        $this->assertNotEquals('refusé', $devis->fresh()->status);
    }

    /** @test */
    public function it_fails_validation_for_reject_devis()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $devis = Devis::factory()->create([
            'status' => 'pending',
            'demandeInscription' => [
                'tuteur' => [
                    'user' => [
                        'idUser' => $user->idUser,
                    ],
                ],
            ],
        ]);

        $response = $this->postJson(route('devis.reject', $devis->id), ['reason' => str_repeat('a', 256)]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['reason']);
        $this->assertNotEquals('refusé', $devis->fresh()->status);
    }

    /** @test */
    public function it_handles_email_sending_error_on_accept_devis()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $devis = Devis::factory()->create([
            'status' => 'pending',
            'demandeInscription' => [
                'tuteur' => [
                    'user' => [
                        'idUser' => $user->idUser,
                        'email' => $user->email,
                    ],
                ],
            ],
        ]);

        Mail::shouldReceive('send')->andThrow(new \Exception('Email error'));

        $response = $this->postJson(route('devis.accept', $devis->id));

        $response->assertStatus(500);
        $response->assertJson(['error' => 'Failed to send email']);
        $this->assertEquals('accepté', $devis->fresh()->status);
    }

    /** @test */
    public function it_returns_404_if_devis_not_found_on_accept()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('devis.accept', 999));

        $response->assertStatus(404);
    }

    /** @test */
    public function it_returns_404_if_devis_not_found_on_reject()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('devis.reject', 999));

        $response->assertStatus(404);
    }

    /** @test */
    public function it_correctly_updates_devis_status_on_accept()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $devis = Devis::factory()->create([
            'status' => 'pending',
            'demandeInscription' => [
                'tuteur' => [
                    'user' => [
                        'idUser' => $user->idUser,
                        'email' => $user->email,
                    ],
                ],
            ],
        ]);

        $response = $this->postJson(route('devis.accept', $devis->id));

        $response->assertStatus(200);
        $this->assertEquals('accepté', $devis->fresh()->status);
    }

    /** @test */
    public function it_correctly_creates_notification_on_accept()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $devis = Devis::factory()->create([
            'status' => 'pending',
            'demandeInscription' => [
                'tuteur' => [
                    'user' => [
                        'idUser' => $user->idUser,
                        'email' => $user->email,
                    ],
                ],
            ],
        ]);

        $this->postJson(route('devis.accept', $devis->id));

        $this->assertDatabaseHas('notifications', [
            'idUser' => $user->idUser,
            'contenu' => 'Votre devis a été accepté. La facture a été générée et envoyée à votre adresse email.',
        ]);
    }

    /** @test */
    public function it_correctly_updates_devis_status_on_reject()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $devis = Devis::factory()->create([
            'status' => 'pending',
            'demandeInscription' => [
                'tuteur' => [
                    'user' => [
                        'idUser' => $user->idUser,
                    ],
                ],
            ],
        ]);

        $reason = 'Not satisfied with the terms.';
        $response = $this->postJson(route('devis.reject', $devis->id), ['reason' => $reason]);

        $response->assertStatus(200);
        $this->assertEquals('refusé', $devis->fresh()->status);
        $this->assertEquals($reason, $devis->fresh()->rejection_reason);
    }

    /** @test */
    public function it_correctly_creates_notification_on_reject()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $devis = Devis::factory()->create([
            'status' => 'pending',
            'demandeInscription' => [
                'tuteur' => [
                    'user' => [
                        'idUser' => $user->idUser,
                    ],
                ],
            ],
        ]);

        $reason = 'Not satisfied with the terms.';
        $this->postJson(route('devis.reject', $devis->id), ['reason' => $reason]);

        $this->assertDatabaseHas('notifications', [
            'idUser' => $user->idUser,
            'contenu' => 'Votre devis a été refusé. Raison : ' . $reason,
        ]);
    }

    /** @test */
    public function it_does_not_allow_duplicate_accept_devis()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $devis = Devis::factory()->create([
            'status' => 'accepté',
            'demandeInscription' => [
                'tuteur' => [
                    'user' => [
                        'idUser' => $user->idUser,
                        'email' => $user->email,
                    ],
                ],
            ],
        ]);

        $response = $this->postJson(route('devis.accept', $devis->id));

        $response->assertStatus(200);
        $this->assertEquals('accepté', $devis->fresh()->status);
    }

    /** @test */
    public function it_does_not_allow_duplicate_reject_devis()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $devis = Devis::factory()->create([
            'status' => 'refusé',
            'rejection_reason' => 'Already rejected.',
            'demandeInscription' => [
                'tuteur' => [
                    'user' => [
                        'idUser' => $user->idUser,
                    ],
                ],
            ],
        ]);

        $reason = 'Not satisfied with the terms.';
        $response = $this->postJson(route('devis.reject', $devis->id), ['reason' => $reason]);

        $response->assertStatus(200);
        $this->assertEquals('refusé', $devis->fresh()->status);
        $this->assertEquals('Already rejected.', $devis->fresh()->rejection_reason);
    }


     /** @test */
     public function it_returns_401_if_user_not_authenticated_on_accept()
     {
         $response = $this->postJson(route('devis.accept', 1));
 
         $response->assertStatus(401);
     }
 
     /** @test */
     public function it_returns_401_if_user_not_authenticated_on_reject()
     {
         $response = $this->postJson(route('devis.reject', 1));
 
         $response->assertStatus(401);
     }
 
     /** @test */
     public function it_returns_400_if_devis_already_processed_on_accept()
     {
         $user = User::factory()->create();
         $this->actingAs($user);
 
         $devis = Devis::factory()->create([
             'status' => 'accepté',
         ]);
 
         $response = $this->postJson(route('devis.accept', $devis->id));
 
         $response->assertStatus(400);
     }
 
     /** @test */
     public function it_returns_400_if_devis_already_processed_on_reject()
     {
         $user = User::factory()->create();
         $this->actingAs($user);
 
         $devis = Devis::factory()->create([
             'status' => 'refusé',
         ]);
 
         $response = $this->postJson(route('devis.reject', $devis->id));
 
         $response->assertStatus(400);
     }
 
     /** @test */
     public function it_does_not_create_notification_if_email_sending_fails_on_accept()
     {
         $user = User::factory()->create();
         $this->actingAs($user);
 
         $devis = Devis::factory()->create([
             'status' => 'pending',
             'demandeInscription' => [
                 'tuteur' => [
                     'user' => [
                         'idUser' => $user->idUser,
                         'email' => $user->email,
                     ],
                 ],
             ],
         ]);
 
         Mail::shouldReceive('send')->andThrow(new \Exception('Email error'));
 
         $this->postJson(route('devis.accept', $devis->id));
 
         $this->assertDatabaseMissing('notifications', [
             'idUser' => $user->idUser,
             'contenu' => 'Votre devis a été accepté. La facture a été générée et envoyée à votre adresse email.',
         ]);
     }
}

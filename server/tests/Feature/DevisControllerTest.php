<?php

namespace Tests\Feature;
use App\Models\Devis;
use App\Models\Facture;
use App\Models\Notification;
use App\Models\User;
use App\Models\Tuteur;
use App\Models\Administrateur;
use App\Models\DemandeInscription;
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
        $this->admin = Administrateur::factory()->create();
        $this->useradmin = User::find($this->admin->idUser);
        $this->tuteur = Tuteur::factory()->create();
        $this->user = User::find($this->tuteur->idUser);
        $this->notif = Notification::factory()->create(["idUser"=>$this->useradmin->idUser]);
        $this->demande = DemandeInscription::factory()->create(["idTuteur"=>$this->tuteur->idTuteur]);
        $this->devis = Devis::factory()->create([
            'status' => 'en_attente',
            'idFacture' => Facture::factory()->create(['idNotification'=>$this->notif->idNotification] ),
            'idNotification' =>$this->notif->idNotification,
            'idDemande' => $this->demande->idDemande,
        ]);
        // dd('1');
}


    /** @test */
    public function it_can_accept_devis()
    {
        $this->actingAs($this->user);

        
        $id = $this->devis->idDevis;
        $response = $this->postJson("api/parent/devis/$id/accept");

        $response->assertStatus(200);
        $this->assertEquals('accepté', $this->devis->fresh()->status);
        $this->assertDatabaseHas('notifications', [
            'idUser' => $this->user->idUser,
            'contenu' => 'Votre devis a été accepté. La facture a été générée et envoyée à votre adresse email.',
        ]);
        // $user = $this->useradmin;
        // Mail::assertSent(DevisAcceptedMail::class, function ($mail) use ($user) {
        //     return $mail->hasTo($user->email);
        // });
    }

    /** @test */
    public function it_can_reject_devis()
    {
        $user = User::factory()->create();
        $this->actingAs($this->user);

        $reason = 'Not satisfied with the terms.';
        $id = $this->devis->idDevis;
        $response = $this->postJson("api/parent/devis/$id/reject", ['reason' => $reason]);

        $response->assertStatus(200);
        $this->assertEquals('refusé', $this->devis->fresh()->status);
        $this->assertEquals($reason, $this->devis->fresh()->rejection_reason);
        $this->assertDatabaseHas('notifications', [
            'idUser' => $this->user->idUser,
            'contenu' => 'Votre devis a été refusé. Raison : ' . $reason,
        ]);
    }


    /** @test */
    public function it_cannot_accept_devis_without_permission()
    {
        $anotherUser = User::factory()->create();
        $this->actingAs($anotherUser);

        Gate::define('manage-devis', function ($anotherUser, $devis) {
            return $anotherUser->idUser === $this->devis->demandeInscription->tuteur->user->idUser;
        });
        $id = $this->devis->idDevis;
        $response = $this->postJson("api/parent/devis/$id/accept");

        $response->assertStatus(403);
        $this->assertNotEquals('accepté', $this->devis->fresh()->status);
    }

    /** @test */
    public function it_cannot_reject_devis_without_permission()
    {
        $anotherUser = User::factory()->create();
        $this->actingAs($anotherUser);

        Gate::define('manage-devis', function ($anotherUser, $devis) {
            return $anotherUser->idUser === $this->devis->demandeInscription->tuteur->user->idUser;
        });
        $id = $this->devis->idDevis;
        $response = $this->postJson("api/parent/devis/$id/reject", ['reason' => 'Reason']);

        $response->assertStatus(403);
        $this->assertNotEquals('refusé', $this->devis->fresh()->status);
    }

    /** @test */
    public function it_fails_validation_for_reject_devis()
    {
        $this->actingAs($this->user);
        $id = $this->devis->idDevis;
        $response = $this->postJson("api/parent/devis/$id/reject", ['reason' => str_repeat('a', 256)]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['reason']);
        $this->assertNotEquals('refusé', $this->devis->fresh()->status);
    }

    /** @test */
    public function it_returns_404_if_devis_not_found_on_accept()
    {
        $this->actingAs($this->user);

        $response = $this->postJson("api/parent/devis/999/accept");

        $response->assertStatus(404);
    }

    /** @test */
    public function it_returns_404_if_devis_not_found_on_reject()
    {
        $this->actingAs($this->user);

        $response = $this->postJson("api/parent/devis/999/reject");

        $response->assertStatus(404);
    }

    /** @test */
    public function it_correctly_updates_devis_status_on_accept()
    {
        $this->actingAs($this->user);
        $id = $this->devis->idDevis;
        $response = $this->postJson("api/parent/devis/$id/accept");

        $response->assertStatus(200);
        $this->assertEquals('accepté', $this->devis->fresh()->status);
    }

    /** @test */
    public function it_correctly_creates_notification_on_accept()
    {
        $this->actingAs($this->user);
        $id = $this->devis->idDevis;
        $this->postJson("api/parent/devis/$id/accept");

        $this->assertDatabaseHas('notifications', [
            'idUser' => $this->user->idUser,
            'contenu' => 'Votre devis a été accepté. La facture a été générée et envoyée à votre adresse email.',
        ]);
    }

    /** @test */
    public function it_correctly_updates_devis_status_on_reject()
    {
        $this->actingAs($this->user);

        $reason = 'Not satisfied with the terms.';
        $id = $this->devis->idDevis;
        $response = $this->postJson("api/parent/devis/$id/reject", ['reason' => $reason]);

        $response->assertStatus(200);
        $this->assertEquals('refusé', $this->devis->fresh()->status);
        $this->assertEquals($reason, $this->devis->fresh()->rejection_reason);
    }

    /** @test */
    public function it_correctly_creates_notification_on_reject()
    {
        $this->actingAs($this->user);
        $id = $this->devis->idDevis;
        $reason = 'Not satisfied with the terms.';
        $this->postJson("api/parent/devis/$id/reject", ['reason' => $reason]);

        $this->assertDatabaseHas('notifications', [
            'idUser' => $this->user->idUser,
            'contenu' => 'Votre devis a été refusé. Raison : ' . $reason,
        ]);
    }

    /** @test */
    public function it_does_not_allow_duplicate_accept_devis()
    {
        $this->actingAs($this->user);
        $id = $this->devis->idDevis;
        $response = $this->postJson("api/parent/devis/$id/accept");

        $response->assertStatus(200);
        $this->assertEquals('accepté', $this->devis->fresh()->status);
    }

    /** @test */
    public function it_does_not_allow_duplicate_reject_devis()
    {
        $this->actingAs($this->user);
        $this->devis->update([
            'status' => 'refusé',
        ]);
        $id = $this->devis->idDevis;
        // dd($this->devis->status);
        $reason = 'Not satisfied with the terms.';
        $response = $this->postJson("api/parent/devis/$id/reject", ['reason' => $reason]);

        $response->assertStatus(200);
        $this->assertEquals('refusé', $this->devis->fresh()->status);
        // dd($this->devis->fresh()->rejection_reason);s
        $this->assertEquals('Already rejected.', $this->devis->fresh()->rejection_reason);
    }


     /** @test */
     public function it_returns_401_if_user_not_authenticated_on_accept()
     {
         $response = $this->postJson("api/parent/devis/1/accept");
 
         $response->assertStatus(401);
     }
 
     /** @test */
     public function it_returns_401_if_user_not_authenticated_on_reject()
     {
         $response = $this->postJson("api/parent/devis/1/reject");
 
         $response->assertStatus(401);
     }
 
     /** @test */
     public function it_returns_400_if_devis_already_processed_on_accept()
     {
         $this->actingAs($this->user);
 
         $this->devis->status = 'accepté';
         $id = $this->devis->idDevis;
         $response = $this->postJson("api/parent/devis/$id/accept");
 
         $response->assertStatus(400);
     }
 
     /** @test */
     public function it_returns_400_if_devis_already_processed_on_reject()
     {
         $this->actingAs($this->user);
         $this->devis->status = 'refusé';
         $id = $this->devis->idDevis;
 
         $response = $this->postJson("api/parent/devis/$id/reject");
 
         $response->assertStatus(400);
     }
 
     /** @test */
     public function it_does_not_create_notification_if_email_sending_fails_on_accept()
     {
         $this->actingAs($this->user);
 
         Mail::shouldReceive('send')->andThrow(new \Exception('Email error'));
         $id = $this->devis->idDevis;
         $this->postJson("api/parent/devis/$id/accept");
 
         $this->assertDatabaseMissing('notifications', [
             'idUser' => $this->user->idUser,
             'contenu' => 'Votre devis a été accepté. La facture a été générée et envoyée à votre adresse email.',
         ]);
     }
}

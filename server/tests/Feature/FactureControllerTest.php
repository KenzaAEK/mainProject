<?php

namespace Tests\Feature;

use App\Http\Controllers\FactureController;
use App\Models\Facture;
use App\Models\Administrateur;
use App\Models\User;
use App\Models\Tuteur;
use App\Models\Notification;
use App\Models\DemandeInscription;
use App\Models\Devis;
// use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Barryvdh\DomPDF\Facade\Pdf;
use Mockery;
use Tests\TestCase;

class FactureControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->factureController = new FactureController();
        $this->admin = Administrateur::factory()->create();
        $this->useradmin = User::find($this->admin->idUser);
        $this->tuteur = Tuteur::factory()->create();
        $this->user = User::find($this->tuteur->idUser);
        $this->notif = Notification::factory()->create(["idUser"=>$this->useradmin->idUser]);
        $this->demande = DemandeInscription::factory()->create(["idTuteur"=>$this->tuteur->idTuteur]);
        $this->facture=Facture::factory()->create(['idNotification'=>$this->notif->idNotification] );
        $this->devis = Devis::factory()->create([
            'status' => 'accepté',
            'idFacture' =>$this->facture->idFacture ,
            'idNotification' =>$this->notif->idNotification,
            'idDemande' => $this->demande->idDemande,
        ]);
        
    }



    public function testDownloadPdf()
    {
        $id = $this->facture->idFacture;
        // Mock the PDF facade
        
        // Mock the PDF facade
        Pdf::shouldReceive('loadView')
            ->once()
            ->andReturnSelf();
        Pdf::shouldReceive('download')
            ->once()
            ->andReturnUsing(function () {
                $response = response('PDF content');
                return $response;
            });

        // Fake the Gate response
        Gate::shouldReceive('denies')
            ->with('download-facture', $id)
            ->andReturn(false);

        // Act as the created user
        $this->actingAs($this->user);

        // Call the downloadPdf method
        $response = $this->post("api/parent/facture-download/$id");

        // Assert the response
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'attachment; filename="facture_' . $id . '.pdf"');
        $this->assertEquals('PDF content', $response->getContent());
    }

    public function testDownloadPdfAccessDenied()
    {
        // Create a user and a facture
        $id = $this->facture->idFacture;

        // Fake the Gate response
        Gate::shouldReceive('denies')
            ->with('download-facture', $id)
            ->andReturn(true);

        // Act as the created user
        $this->actingAs($this->user);

        // Call the downloadPdf method
        $response = $this->post("api/parent/facture-download/$id");

        // Assert the response
        $response->assertStatus(403);
        $response->assertJson(['message' => 'ACCES INTERDIT']);
    }

    // public function testDownloadPdfUnauthenticated()
    // {
    //     // Create a facture
    //     $id = $this->facture->idFacture;

    //     // Call the downloadPdf method without authenticating a user
    //     $response = $this->post("api/parent/facture-download/$id");
    //     // dd($response);
    //     // Assert the response
    //     $response->assertStatus(302); // Redirection to login page
    //     $response->assertRedirect('/api/login');
    // }

    public function testDownloadPdfNotFound()
    {
        // Create a user
        // $id = $this->facture->idFacture;

        // Act as the created user
        $this->actingAs($this->user);

        // Call the downloadPdf method with a non-existent facture ID
        $response = $this->post("api/parent/facture-download/999");

        // Assert the response
        $response->assertStatus(404);
    }

}

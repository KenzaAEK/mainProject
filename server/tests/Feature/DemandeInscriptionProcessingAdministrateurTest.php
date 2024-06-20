<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tuteur;
use App\Models\Enfant;
use Mockery;
use App\Models\DemandeInscription;
use App\Models\Administrateur;
use App\Models\offreActivite;
use App\Models\Offre;
use Illuminate\Support\Facades\DB;

class DemandeInscriptionProcessingAdministrateurTest extends TestCase
{
    use RefreshDatabase;
    public function setUp():void{
        parent::setUp();
        $this->tuteur = Tuteur::factory()->create();
        $this->enfant = Enfant::factory()->create(['idTuteur'=>$this->tuteur->idTuteur]);
        $this->admin = Administrateur::factory()->create();
        $this->user = User::find($this->admin->idUser);
        $this->ofac = offreActivite::factory()->create(['idOffre'=>Offre::factory()->create(['idAdmin'=>$this->admin->idAdmin])]);
        $this->demande = DemandeInscription::factory()->create([
            'status' => 'en attente',
            'idTuteur' => $this->tuteur->idTuteur // Assurez-vous que les IDs correspondent
        ]);
        // dd('1');
    }

    /** @test */
    public function it_can_reject_demande()
    {
        // $user = User::factory()->create();
        // $demande = DemandeInscription::factory()->create([
        //     'status' => 'en attente',
        //     'idTuteur' => 1 // Assurez-vous que les IDs correspondent
        // ]);
        // dd($this->demande);
        $id = $this->demande->idDemande;
        $response = $this->actingAs($this->user)->postJson("/api/admin/reject-demande/$id");
        // dd('1');
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Demande refusée avec succès.']);

        $this->assertDatabaseHas('demande_inscriptions', [
            'idDemande' => $this->demande->idDemande,
            'status' => 'refusée'
        ]);

        $this->assertDatabaseHas('notifications', [
            'contenu' => "La demande a été refusée. Nous vous remercions pour votre compréhension. Veuillez nous excuser pour tout désagrément. Pour plus de détails, veuillez contacter notre personnel "
        ]);

        $this->assertDatabaseMissing('inscriptionEnfant_offre_Activite', [
            'idDemande' => $this->demande->idDemande
        ]);

        // $this->assertDatabaseMissing('demande_inscriptions', [
        //     'idDemande' => $this->demande->idDemande
        // ]);
    }



    //Il faut une base de donnees Postgres pour ca
     /** @test */
    //  public function it_can_list_demandes_with_pagination()
    //  {
    //      // Mock the DB facade
    //      $mock = Mockery::mock('alias:DB');
 
    //      // Define the mock behavior for the select method
    //      $mock->shouldReceive('select')
    //          ->with('SELECT * FROM get_demande_details()')
    //          ->andReturn(collect(array_map(function ($i) {
    //              return (object) ['idDemande' => $i, 'status' => 'status' . $i];
    //          }, range(1, 20))));
 
    //      // Use the real DB facade for other calls
    //      $mock->makePartial();
 
    //      DemandeInscription::factory()->count(20)->create();
 
    //      $response = $this->actingAs($this->user)->getJson('/api/admin/show-demande?page=1');
    //      $response->assertStatus(200);
    //     //  dd($response);
    //      $response->assertJsonStructure([
    //          'current_page',
    //          'data' => [
    //              '*' => [
    //                   'status',
    //                   'date_demande',
    //                   'nom_tuteur',
    //                   'prenom_tuteur',
    //                   'email_tuteur'
    //              ]
    //          ],
    //          'total',
    //          'per_page',
    //          'last_page',
    //          'from',
    //          'to'
    //      ]);

    //      $this->assertCount(8, $response->json('data'));
 
    //      $response = $this->getJson('/api/admin/show-demande?page=2');
    //      $this->assertCount(8, $response->json('data'));
 
    //      $response = $this->getJson('/api/admin/show-demande?page=3');
    //      $this->assertCount(5, $response->json('data'));
 
    //      // Close Mockery
    //      Mockery::close();
    //  }

    /** @test */
    public function it_requires_idDemande_to_approve()
    {
        // $user = User::factory()->create();
        // $id='a';
        $response = $this->actingAs($this->user)->postJson("/api/admin/approve-demande/[]");

        $response->assertStatus(500);
        // $response->assertJsonValidationErrors(['idDemande']);
    }

    /** @test */
    public function it_returns_404_if_demande_not_found()
    {

        $response = $this->actingAs($this->user)->postJson('/api/admin/reject-demande/', ['idDemande' => 999]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_creates_notification_devis_and_facture_on_approve()
    {

        DB::table('inscriptionEnfant_offre_Activite')->insert([
            'idDemande' => $this->demande->idDemande,
            'Prixbrute' => 100,
            'PixtotalRemise' => 90,
            'idTuteur'=>$this->tuteur->idTuteur,
            'idEnfant'=>$this->enfant->idEnfant,
            'idOffre'=>$this->ofac->idOffre,
            'idActivite'=>$this->ofac->idActivite,
        ]);
        $id = $this->demande->idDemande;
        $response = $this->actingAs($this->user)->postJson("/api/admin/approve-demande/$id");

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Demande approuvée et devis généré']);

        $this->assertDatabaseHas('notifications', [
            'idUser' => $this->tuteur->idUser,
            'contenu' => "Votre devis a été créé et est prêt pour révision.",
        ]);

        $this->assertDatabaseHas('factures', [
            'totalHT' => 100,
            'totalTTC' => 91.8, // 90 + 2% TVA
            'facturePdf' => 'test.pdf',
        ]);

        $this->assertDatabaseHas('devis', [
            'idDemande' => $this->demande->idDemande,
            'totalHT' => 100,
            'totalTTC' => 91.8,
            'devisPdf' => 'dev.pdf',
        ]);
    }


    /** @test */
    public function it_sends_notification_and_deletes_demande_on_reject()
    {

        DB::table('inscriptionEnfant_offre_Activite')->insert([
            'idDemande' => $this->demande->idDemande,
            'Prixbrute' => 100,
            'PixtotalRemise' => 90,
            'idTuteur'=>$this->tuteur->idTuteur,
            'idEnfant'=>$this->enfant->idEnfant,
            'idOffre'=>$this->ofac->idOffre,
            'idActivite'=>$this->ofac->idActivite,
        ]);
        $id = $this->demande->idDemande;
        $response = $this->actingAs($this->user)->postJson("/api/admin/reject-demande/$id");

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Demande refusée avec succès.']);

        $this->assertDatabaseHas('notifications', [
            'idUser' => $this->tuteur->idUser,
            'contenu' => "La demande a été refusée. Nous vous remercions pour votre compréhension. Veuillez nous excuser pour tout désagrément. Pour plus de détails, veuillez contacter notre personnel "
        ]);

        // $this->assertDatabaseMissing('demande_inscriptions', ['idDemande' => $demande->idDemande]);
        $this->assertDatabaseMissing('inscriptionEnfant_offre_Activite', ['idDemande' => $this->demande->idDemande]);
    }

    /**
     * @dataProvider provideDemandeData
     */
    public function test_it_approves_demande($prixBrute, $prixTotalRemise, $expectedTotalTTC)
    {
        DB::table('inscriptionEnfant_offre_Activite')->insert([
            'idDemande' => $this->demande->idDemande,
            'Prixbrute' => $prixBrute,
            'PixtotalRemise' => $prixTotalRemise,
            'idTuteur'=>$this->tuteur->idTuteur,
            'idEnfant'=>$this->enfant->idEnfant,
            'idOffre'=>$this->ofac->idOffre,
            'idActivite'=>$this->ofac->idActivite,
        ]);
        $id = $this->demande->idDemande;
        $response = $this->actingAs($this->user)->postJson("/api/admin/approve-demande/$id");
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Demande approuvée et devis généré']);

        $this->assertDatabaseHas('factures', [
            'totalTTC' => $expectedTotalTTC,
        ]);
    }

    public function provideDemandeData()
    {
        return [
            'Case 1' => [100, 90, 91.8],
            'Case 2' => [200, 180, 183.6],
            'Case 3' => [300, 270, 275.4],
        ];
    }

}

<?php

namespace Tests\Feature;

use App\Http\Controllers\FactureController;
use App\Models\Facture;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FactureControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->factureController = new FactureController();
    }

    /** @test */
    public function it_generates_pdf_content()
    {
        $facture = Facture::factory()->create();
        $pdfContent = $this->factureController->generatePdfContent($facture);

        $this->assertNotNull($pdfContent);
        // You can add more specific assertions here based on your PDF content
    }

    /** @test */
    public function it_returns_pdf_response()
    {
        $facture = Facture::factory()->create();
        $pdfContent = $this->factureController->generatePdfContent($facture);

        $response = $this->factureController->downloadPdf($facture->idFacture);

        $this->assertEquals(200, $response->status());
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
        $this->assertEquals(
            'attachment; filename="facture_' . $facture->idFacture . '.pdf"',
            $response->headers->get('Content-Disposition')
        );
        $this->assertEquals($pdfContent, $response->getContent());
    }

    /** @test */
    public function it_returns_403_if_access_denied()
    {
        $facture = Facture::factory()->create();

        Gate::shouldReceive('denies')->andReturn(true);

        $response = $this->factureController->downloadPdf($facture->idFacture);

        $this->assertEquals(403, $response->status());
        $this->assertEquals('ACCES INTERDIT', $response->json()['message']);
    }

    /** @test */
    public function it_returns_401_if_user_not_authenticated_on_download_pdf()
    {
        $response = $this->factureController->downloadPdf(1);

        $response->assertStatus(401);
    }

    /** @test */
    public function it_returns_404_if_facture_not_found_on_download_pdf()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->factureController->downloadPdf(999);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_generates_empty_pdf_content_if_facture_has_no_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $facture = Facture::factory()->create(['data' => null]);

        $pdfContent = $this->factureController->generatePdfContent($facture);

        $this->assertNotNull($pdfContent);
        $this->assertEmpty($pdfContent);
    }

    /** @test */
    public function it_returns_403_if_access_denied_on_download_pdf()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $facture = Facture::factory()->create();
        Gate::shouldReceive('denies')->andReturn(true);

        $response = $this->factureController->downloadPdf($facture->idFacture);

        $response->assertStatus(403);
    }

}

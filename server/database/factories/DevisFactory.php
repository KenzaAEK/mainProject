<?php

namespace Database\Factories;

use App\Models\DemandeInscription;
use App\Models\Facture;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Devis>
 */
class DevisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'totalHT' => $this->faker->randomFloat(2, 100, 1000),
            'totalTTC' => $this->faker->randomFloat(2, 120, 1200),
            'TVA' => $this->faker->randomFloat(2, 10, 100),
            'devisPdf' => $this->faker->url,
            'idNotification' => Notification::factory()->create()->idNotification,
            'idFacture' => Facture::factory()->create()->idFacture,
            'idDemande' => DemandeInscription::factory()->create()->idDemande,
            'status' => $this->faker->randomElement(['en_attente', 'accepté', 'refusé']),
        ];
    }
}

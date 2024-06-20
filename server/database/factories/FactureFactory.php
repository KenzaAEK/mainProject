<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facture>
 */
class FactureFactory extends Factory
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
            'dateFacture' => $this->faker->date(),
            'facturePdf' => $this->faker->url,
            'idNotification' => Notification::factory()->create()->idNotification,
        ];
    }
}

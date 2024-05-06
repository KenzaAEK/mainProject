<?php

namespace Database\Factories;

use App\Models\Facture;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactureFactory extends Factory
{
    protected $model = Facture::class;

    public function definition()
    {
        return [
            'totalHT' => $this->faker->randomFloat(2, 100, 1000),
            'totalTTC' => $this->faker->randomFloat(2, 120, 1200),
            'dateFacture' => now(),
            'facturePdf' => $this->faker->url(),
        ];
    }
}

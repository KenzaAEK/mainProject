<?php

namespace Database\Factories;

use App\Models\TypeActivite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activite>
 */
class ActiviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titre' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'objectif' => $this->faker->sentence(10), // Limit the sentence length to 10 words
            'imagePub' => $this->faker->imageUrl(640, 480),
            'lienYtb' => $this->faker->url,
            'programmePdf' => $this->faker->url,
            'idTypeActivite' => TypeActivite::factory(),
        ];
    }
}

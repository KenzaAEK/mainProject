<?php
namespace Database\Factories;

use App\Models\typeActivite;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActiviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idTypeActivite' => 2,
            'titre' => $this->faker->text(50),
            'description' => $this->faker->paragraph,
            'objectif' => $this->faker->sentence(10), // Limit the sentence length to 10 words
            'imagePub' => $this->faker->imageUrl(640, 480),
            'lienYtb' => $this->faker->url,
            'programmePdf' => $this->faker->url,
            'idTypeActivite' => TypeActivite::factory(),
        ];
    }
}

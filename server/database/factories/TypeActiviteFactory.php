<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Type_activite>
 */
class TypeActiviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
<<<<<<< HEAD
{
    $types = [ 'Musique', 'Science'];
    foreach ($types as $type) {
        TypeActivite::firstOrCreate([
            'type' => $type,
            'domaine' => 'Exterieur' // ou une logique pour assigner le domaine
        ]);
=======
    {
        return [
            'type' => $this->faker->unique()->word, // Generate a unique word for the 'type' column
            'domaine' => $this->faker->word,
        ];
>>>>>>> d19a5a606ce527f55e39d0d4420fa72ca3b7d0ea
    }
}

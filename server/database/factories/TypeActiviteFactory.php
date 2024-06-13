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
{
    $types = [ 'Musique', 'Science'];
    foreach ($types as $type) {
        TypeActivite::firstOrCreate([
            'type' => $type,
            'domaine' => 'Exterieur' // ou une logique pour assigner le domaine
        ]);
    }
}
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Horaire>
 */
class HoraireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'jour' => $this->faker->dayOfWeek(), // Utilisation de Faker pour générer un jour de la semaine aléatoire
            'heureDebut' => $this->faker->time('H:i'), // Utilisation de Faker pour générer une heure de début aléatoire
            'heureFin' => $this->faker->time('H:i'),
        ];
    }
}

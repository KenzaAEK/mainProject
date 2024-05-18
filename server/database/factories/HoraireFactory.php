<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class HoraireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        $heureDebut = $this->faker->numberBetween(8, 16); // Heure de début entre 8h et 16h

        return [
            'jour' => $this->faker->randomElement($jours),
            'heureDebut' => Carbon::createFromTime($heureDebut, 0, 0, 'Europe/Paris'),
            'heureFin' => Carbon::createFromTime($heureDebut + 1, 0, 0, 'Europe/Paris'), // +1 heure après l'heure de début
        ];
    }
}

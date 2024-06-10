<?php

namespace Database\Factories;

use App\Models\OffreActivite;
use App\Models\Animateur;
// use App\Models\typeActivite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Groupe>
 */
class GroupeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'Nomgrp' => $this->faker->word(), // Utilisation de Faker pour générer un mot aléatoire
            'idOffre' => OffreActivite::factory()->create()->idOffre, // Crée une offre activité si elle n'existe pas
            'idActivite' => OffreActivite::factory()->create()->idActivite, // Crée une activité si elle n'existe pas
            'idAnimateur' => Animateur::factory()->create()->idAnimateur, 
        ];
    }
}

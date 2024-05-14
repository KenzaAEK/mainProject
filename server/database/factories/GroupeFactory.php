<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Offre;
use App\Models\Activite;
use App\Models\Animateur;

class GroupeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $offreactivite = \App\Models\Offreactivite::inRandomOrder()->first();
        return [
            'Nomgrp' => $this->faker->word,
            'idOffre' => $offreactivite->idOffre,
            'idActivite' => $offreactivite->idActivite,
            'idAnimateur' => \App\Models\Animateur::inRandomOrder()->first()->idAnimateur,
        ];
    }
}

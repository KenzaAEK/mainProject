<?php

namespace Database\Factories;
use App\Models\Administrateur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offre>
 */
class OffreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titre'=>$this->faker->word,
            'remise' =>rand(2,5),
            'dateDebutOffre'=>now(),
            'dateFinOffre' =>now(),
            'description' =>$this->faker->text,
            'idAdmin' =>Administrateur::factory()->create()->idAdmin,
        ];
    }
}
<?php

namespace Database\Factories;

use App\Models\Administrateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Administrateur::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idUser' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            // Ajoutez d'autres attributs si nécessaire
        ];
    }
}
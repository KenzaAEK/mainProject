<?php

namespace Database\Factories;

use App\Models\Tuteur;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TuteurFactory extends Factory
{
    protected $model = Tuteur::class;

    public function definition()
    {
        return [
            'idUser' => User::factory(), // Crée automatiquement un utilisateur et utilise son ID
            'fonction' => $this->faker->jobTitle
        ];
    }
}

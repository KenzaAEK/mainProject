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
            'idUser' => User::factory()->create()->idUser,
            'fonction' => $this->faker->sentence(2),
        ];
    }
}

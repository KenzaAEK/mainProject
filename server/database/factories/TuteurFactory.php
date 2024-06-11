<?php

namespace Database\Factories;

use App\Models\Tuteur;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tuteur>
 */
class TuteurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'idUser' => User::factory()->create(["role"=>1])->idUser,
            'fonction' => $this->faker->sentence(2),
        ];
    }
}

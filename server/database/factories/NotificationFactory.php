<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'contenu' => $this->faker->sentence,
            'statut' => $this->faker->boolean,
            'idUser' => User::factory()->create()->idUser,
            'read_at' => $this->faker->dateTime,
        ];
    }
}

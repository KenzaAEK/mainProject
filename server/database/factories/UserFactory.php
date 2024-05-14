<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail, // Generate unique email addresses
            'tel' => $this->faker->phoneNumber,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Vous pouvez utiliser la fonction de hachage pour le mot de passe
            'role' => 'user',
            'photo' => null, // Vous pouvez remplir cette valeur selon vos besoins
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

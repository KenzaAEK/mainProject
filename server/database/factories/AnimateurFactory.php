<?php

namespace Database\Factories;
<<<<<<< HEAD

=======
use App\Models\Animateur;
>>>>>>> AnimateurInterface
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animateur>
 */
class AnimateurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
<<<<<<< HEAD
            'idUser' => User::factory()->create()->idUser,
=======
            'idUser' => User::factory()->create(["role"=>3])->idUser,
>>>>>>> AnimateurInterface
        ];
    }
}

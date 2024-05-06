<?php

namespace Database\Factories;

use App\Models\Administrateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdministrateurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Administrateur::class;

    public function definition()
    {
        return [
            // Supposons que idUser doit être lié à des utilisateurs existants ou générés séparément
            'idUser' => \App\Models\User::factory(),
        ];
    }
}

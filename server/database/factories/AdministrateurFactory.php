<?php

namespace Database\Factories;
use App\Models\Administrateur;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;


class AdministrateurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'idUser' => User::factory()->create(["role"=>2,"password"=>Hash::make("passadmin")])->idUser,
        ];
    }
}

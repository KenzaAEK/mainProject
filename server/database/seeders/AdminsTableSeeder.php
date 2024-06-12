<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Administrateur;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupérer l'ID de l'utilisateur "mouad"
        // $mouadId = User::where('email', 'mouaddahbi3333333333@gmail.com')->value('idUser');
        
        // Créer un enregistrement dans la table des administrateurs avec l'ID de "mouad"
        Administrateur::create([
            'idUser' => User::factory()->create(["role"=>2,"email"=>"sy@nf","password"=>Hash::make("123456789")])->idUser,
            // Autres colonnes si nécessaire
        ]);
    }
}
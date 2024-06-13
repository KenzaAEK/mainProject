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
        
        // Administrateur de 
        // mail : sy@nf
        // mdp : passadmin
        Administrateur::create([
            'idUser' => User::factory()->create(["role"=>2,"email"=>"sy@nf","password"=>Hash::make("passadmin")])->idUser,
        ]);
        // Administrateur de 
        // mail : md@ensa
        // mdp : passadmin
        Administrateur::create([
            'idUser' => User::factory()->create(["role"=>2,"email"=>"md@ensa","password"=>Hash::make("passadmin")])->idUser,
        ]);
        // Administrateur de 
        // mail : mh@ensa
        // mdp : passadmin
        Administrateur::create([
            'idUser' => User::factory()->create(["role"=>2,"email"=>"mh@ensa","password"=>Hash::make("passadmin")])->idUser,
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      // \App\Models\User::factory(10)->create();
      // $this->call(TuteurSeeder::class);
      // $this->call(OffreSeeder::class);
      // $this->call(OffreActiviteSeeder::class);
      // $this->call([TuteurSeeder::class,EnfantSeeder::class,]);
      // $this->call([HoraireSeeder::class]);
     // $this->call(AnimateurSeeder::class);
      $this->call(GroupeSeeder::class);
        $this->call([
    
    //  DisponibiliteSeeder::class
       // AnimateurGroupeSeeder::class
        EnfantGroupeSeeder::class
  ]);
      
  }
}


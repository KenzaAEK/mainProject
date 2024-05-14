<?php

namespace Database\Seeders;

use App\Models\Activite;
use App\Models\Administrateur;
use App\Models\Animateur;
use App\Models\DemandeInscription;
use App\Models\Devis;
use App\Models\Enfant;
use App\Models\Facture;
use App\Models\Notification;
use App\Models\Pack;
use App\Models\Tuteur;
use App\Models\User;
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


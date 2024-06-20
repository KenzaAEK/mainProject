<?php

namespace Database\Seeders;
use App\Models\Tuteur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TuteurSeeder extends Seeder
{
    public function run()
    {
        
        Tuteur::factory()->count(15)->create();
    }
}

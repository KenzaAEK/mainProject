<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FactureSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Facture::factory()->count(10)->create();
    }
}

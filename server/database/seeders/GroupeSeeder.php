<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Groupe;

class GroupeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Groupe::factory()->count(50)->create(); // Crée 10 groupes, ajustez le nombre selon vos besoins
    }
}

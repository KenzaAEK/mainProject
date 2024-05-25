<?php



namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimateurFactory extends Factory
{
    /**
     * The name of the model that this factory corresponds to.
     *
     * @var string
     */
    protected $model = Animateur::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idUser' => User::factory()->create()->idUser,
        ];
    }
}

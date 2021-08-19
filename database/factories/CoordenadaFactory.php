<?php

namespace Database\Factories;

use App\Models\Coordenada;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoordenadaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coordenada::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "latitude" => $this->faker->randomFloat(4, -15, 15),
            "longitude" => $this->faker->randomFloat(4, -15, 15),
            "zoom"      => $this->faker->randomFloat(1, 1, 15),
        ];
    }
}

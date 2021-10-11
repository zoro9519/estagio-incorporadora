<?php

namespace Database\Factories;

use App\Models\Lote;
use App\Models\Quadra;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quadra = Quadra::factory()->create();
        return [
            "valor" => $this->faker->randomFloat(2, 1, 300000),
            "descricao" => $this->faker->realText(50),
            "area" => $this->faker->randomFloat(2, 1, 30000),
            "status" => $this->faker->randomElement(['R', 'L', 'V', 'C']),
            "quadra_id" => $quadra,
            "updated_at" => $this->faker->dateTimeBetween(),
            "created_at" => $this->faker->dateTimeBetween()
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Loteamento;
use App\Models\Quadra;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuadraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quadra::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $loteamento = Loteamento::factory()->create();
        return [
            "descricao" => $this->faker->streetName(),
            "loteamento_id" => $loteamento
        ];
    }
}

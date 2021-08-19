<?php

namespace Database\Factories;

use App\Models\Coordenada;
use App\Models\Loteamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoteamentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loteamento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $coordenada = Coordenada::factory()->create();
        return [
            "nome" => $this->faker->company(),
            "link" => str_replace(" ", "", strtolower($this->faker->text(30))),
            "descricao" => $this->faker->realText(),
            "area" => $this->faker->numberBetween(1, 30000),
            "coordenada_id" => $coordenada
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Corretor;
use App\Models\Imobiliaria;
use Illuminate\Database\Eloquent\Factories\Factory;

class CorretorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Corretor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $imobiliaria = Imobiliaria::factory()->create();
        $faker = \Faker\Factory::create('pt_BR');

        return [
            "nome" => $this->faker->name(),
            "documento" => $faker->cpf(),
            "phone" => $faker->phoneNumber(),
            "email" => $faker->email(),
            "taxa_venda_porcentagem" => $this->faker->randomFloat(3, null, 100),
            "taxa_venda_valor" => $this->faker->randomFloat(2, 0, 2000),
            "ativo" => $this->faker->boolean(80),
            "profile_picture" => $this->faker->imageUrl(),
            "imobiliaria_id" => $imobiliaria
        ];
    }
}

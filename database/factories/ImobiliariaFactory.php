<?php

namespace Database\Factories;

use App\Models\Imobiliaria;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImobiliariaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Imobiliaria::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('pt_BR');
        return [
            'nome' => $this->faker->streetName(),
            'razao_social' => $this->faker->company(),

            'cnpj' => $faker->cnpj(),
            'creci' => $this->faker->numerify("######"),
            'status' => $this->faker->boolean(),

            'logradouro' => $this->faker->streetAddress(),
            'numero' => $this->faker->numberBetween(1, 5000),
            'bairro' => $this->faker->streetName(),
            'cidade' => $this->faker->city(),
            'uf' => $this->faker->stateAbbr(),
            'cep' => $this->faker->numerify("##########"),
            'email' => $this->faker->companyEmail(),

        ];
    }
}

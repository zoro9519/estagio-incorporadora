<?php

namespace Database\Factories;

use App\Models\Agendamento;
use App\Models\Corretor;
use App\Models\Lote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

class AgendamentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Agendamento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lote = Lote::factory()->create();
        $user = User::factory()->create();
        $corretor = Corretor::factory()->create();
        return [
            'observacao' => $this->faker->text(60),
            'status' => $this->faker->randomElement(['A', 'C', 'E', 'N', 'R']),
            'lote_id' => $lote,
            'loteamento_id' => $lote->loteamento,
            'user_id' => $user,
            'corretor_id' => $corretor,
            'type' => $this->faker->randomElement(['V', 'R']),
            'data_inicio' => $this->faker->dateTimeBetween("now -15 day", 'now +1 month'),
            'data_fim' => $this->faker->dateTimeBetween("now", 'now +1 month')
        ];
    }
}

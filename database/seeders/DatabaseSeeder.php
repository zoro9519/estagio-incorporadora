<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            [
                'id' => 3054,
                'nome' => "Vitor Pereira",
                'email' => 'vini.vptds@gmail.com',
                'password' => Hash::make('11223344'),
                'cpf' => '417.105.558-07',
                'phone' => '18998109428',
                'status' => 'A',

                'logradouro' => 'Rua Maria Antonia',
                'numero' => '1198',
                'bairro' => 'Vila Rosa',
                'cidade' => "Quatá",
                'uf' => "SP",
                'cep' => '19062270'

            ]
        ]);
        \App\Models\User::factory(10)->create();
        $this->call(AdminSeeder::class);
        $this->call(ImobiliariaSeeder::class);
        $this->call(LoteamentoSeeder::class);
        $this->call(QuadraSeeder::class);
    }
}

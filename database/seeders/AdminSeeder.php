<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("admins")->insert([
            [
                'id' => 3054,
                'nome' => "Vitor Pereira",
                'email' => 'vini.vptds@gmail.com',
                'password' => Hash::make('11223344'),
                'status' => true,

                'logradouro' => 'Rua Maria Antonia',
                'numero' => '1198',
                'bairro' => 'Vila Rosa',
                'cidade' => "Quatá",
                'uf' => "SP",
                'cep' => '19062270'

            ]
        ]);
        \App\Models\Loteamento::factory(3)->create();
    }
}

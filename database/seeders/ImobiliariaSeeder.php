<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImobiliariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Imobiliaria::factory(3)->create();
    }
}

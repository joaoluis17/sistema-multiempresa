<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InitialCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Company::create([
            'name' => 'Empresa Teste',
            'identifier' => 'empresa-teste'
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\{Plan, Tenant};
use Illuminate\Database\Seeder;

class TenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $plan = Plan::first();

        $plan->tenants()->create([
            'cnpj' => '18181223000168',
            'cpf' => '02530471533',
            'name' => 'Canecas Pontocom',
            'url' => 'canecas-pontocom',
            'email' => 'fabiosantanagif@gmail.com',
        ]);
    }
}

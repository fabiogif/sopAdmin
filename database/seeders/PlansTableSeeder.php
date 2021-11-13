<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'name' => 'Free',
            'url' => 'free ',
            'price' =>  0.0,
            'description' => 'Plano grátis para teste',
        ]);
    }
}

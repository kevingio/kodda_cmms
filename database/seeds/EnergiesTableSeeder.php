<?php

use Illuminate\Database\Seeder;
use App\Models\Energy;

class EnergiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Energy::create([
            'lwbp' => 1000,
            'wbp' => 2000,
            'pdam' => 4000,
            'deep_well' => 1000,
            'lpg' => 8000
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\InventoryModel;

class InventoryModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InventoryModel::create([
            'name' => 'Electric'
        ]);

        InventoryModel::create([
            'name' => 'Civil'
        ]);

        InventoryModel::create([
            'name' => 'Mechanic'
        ]);

        InventoryModel::create([
            'name' => 'HVAC'
        ]);
    }
}

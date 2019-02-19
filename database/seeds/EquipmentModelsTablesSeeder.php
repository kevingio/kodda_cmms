<?php

use Illuminate\Database\Seeder;
use App\Models\EquipmentModel;

class EquipmentModelsTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EquipmentModel::create([
            'name' => 'AC'
        ]);

        EquipmentModel::create([
            'name' => 'Genzet'
        ]);
    }
}

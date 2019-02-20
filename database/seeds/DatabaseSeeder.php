<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EnergiesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(LocationsSeeder::class);
        $this->call(InventoryModelsTableSeeder::class);
        $this->call(EquipmentModelsTablesSeeder::class);
        $this->call(JobsTableSeeder::class);
    }
}

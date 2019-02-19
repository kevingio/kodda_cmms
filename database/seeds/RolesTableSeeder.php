<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Super Admin'
        ]);

        Role::create([
            'name' => 'Admin'
        ]);

        Role::create([
            'name' => 'User'
        ]);

        Role::create([
            'name' => 'Engineer'
        ]);

        Role::create([
            'name' => 'Operator'
        ]);

        Role::create([
            'name' => 'Storeman'
        ]);
    }
}

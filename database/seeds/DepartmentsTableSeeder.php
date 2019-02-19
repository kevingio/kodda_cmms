<?php

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name' => 'Front Office'
        ]);

        Department::create([
            'name' => 'Housekeeping'
        ]);

        Department::create([
            'name' => 'Engineering'
        ]);

        Department::create([
            'name' => 'Finance'
        ]);

        Department::create([
            'name' => 'Human Resource'
        ]);

        Department::create([
            'name' => 'Security'
        ]);

        Department::create([
            'name' => 'Reservation'
        ]);

        Department::create([
            'name' => 'Food & Beverage - Service'
        ]);

        Department::create([
            'name' => 'Food & Beverage - Product'
        ]);

        Department::create([
            'name' => 'Sales & Marketing'
        ]);

        Department::create([
            'name' => 'Recreation'
        ]);
    }
}

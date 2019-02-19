<?php

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::create([
            'title' => 'Head of Engineering',
            'department_id' => 3
        ]);

        Job::create([
            'title' => 'Housekeeping Manager',
            'department_id' => 2
        ]);

        Job::create([
            'title' => 'Front Office Manager',
            'department_id' => 1
        ]);

        Job::create([
            'title' => 'Head of Finance',
            'department_id' => 4
        ]);
    }
}

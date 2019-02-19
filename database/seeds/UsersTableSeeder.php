<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'          => 'Kevin Giovanni',
            'username'      => 'kevingio',
            'email'         => 'kevingiovv@gmail.com',
            'password'      => bcrypt('secret'),
            'contact'       => '08112596097',
            'department_id' => 1,
            'job_id'        => 1,
            'role_id'       => 1
        ]);

        User::create([
            'name'          => 'Yanto Lie',
            'username'      => 'yantolie',
            'email'         => 'yanto@gmail.com',
            'password'      => bcrypt('secret'),
            'contact'       => '08112596097',
            'department_id' => 1,
            'job_id'        => 1,
            'role_id'       => 2
        ]);

        User::create([
            'name'          => 'Juniarko',
            'username'      => 'juniarko',
            'email'         => 'juniarko@gmail.com',
            'password'      => bcrypt('secret'),
            'contact'       => '08112596097',
            'department_id' => 1,
            'job_id'        => 1,
            'role_id'       => 3
        ]);

        User::create([
            'name'          => 'Albertus Istore',
            'username'      => 'albertusip',
            'email'         => 'albertusip@gmail.com',
            'password'      => bcrypt('secret'),
            'contact'       => '08112596097',
            'department_id' => 1,
            'job_id'        => 2,
            'role_id'       => 4
        ]);

        User::create([
            'name'          => 'Antony Stefan',
            'username'      => 'aceng',
            'email'         => 'aceng@gmail.com',
            'password'      => bcrypt('secret'),
            'contact'       => '08112596097',
            'department_id' => 1,
            'job_id'        => 2,
            'role_id'       => 4
        ]);

        User::create([
            'name'          => 'Martono Tan',
            'username'      => 'martonotan',
            'email'         => 'tono@gmail.com',
            'password'      => bcrypt('secret'),
            'contact'       => '08112596097',
            'department_id' => 1,
            'job_id'        => 1,
            'role_id'       => 4
        ]);

        User::create([
            'name'          => 'Angel',
            'username'      => 'angle',
            'email'         => 'angel@gmail.com',
            'password'      => bcrypt('secret'),
            'contact'       => '08112596097',
            'department_id' => 1,
            'job_id'        => 1,
            'role_id'       => 5
        ]);

        User::create([
            'name'          => 'Veronika',
            'username'      => 'veronika',
            'email'         => 'veronika@gmail.com',
            'password'      => bcrypt('secret'),
            'contact'       => '08112596097',
            'department_id' => 1,
            'job_id'        => 1,
            'role_id'       => 6
        ]);
    }
}

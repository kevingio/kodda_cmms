<?php

use Illuminate\Database\Seeder;
use App\Models\Floor;
use App\Models\Location;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Floor::create([
            'description' => '1st Floor'
        ]);

        Floor::create([
            'description' => '2nd Floor'
        ]);

        Location::create([
            'floor_id' => 1,
            'area' => 'Balai Kambang'
        ]);

        Location::create([
            'floor_id' => 1,
            'area' => 'Kolam Renang'
        ]);
    }
}

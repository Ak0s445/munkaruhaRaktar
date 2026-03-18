<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['building' => 'A', 'row' => '1', 'shelf' => '1'],
            ['building' => 'A', 'row' => '1', 'shelf' => '2'],
            ['building' => 'A', 'row' => '2', 'shelf' => '1'],
            ['building' => 'B', 'row' => '1', 'shelf' => '1'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}

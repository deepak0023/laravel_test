<?php

namespace Database\Seeders;

// use Illuminate\Support\Facades\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Start City Seeder');

        $city_data = [
            [
                'city_name' => 'Bangalore'
            ], [
                'city_name' => 'Mumbai'
            ], [
                'city_name' => 'Chennai'
            ]
        ];

        foreach($city_data as $data) {
            City::create($data);
        }

        $this->command->info('End City Seeder');
    }
}

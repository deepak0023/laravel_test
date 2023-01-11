<?php

namespace Database\Seeders;

// use Illuminate\Support\Facades\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CityTravelHistory;

class CityTravelHistorySeeder extends Seeder
{

    // ** These values are to be actually added by the customer through ui . This is a test case **


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Start City Travel History Seeder');

        $city_travel_data = [
            [
                'traveller_id' => 1,
                'city_id' => 2,
                'from_date' => '2022-12-22 10:10:10',
                'to_date' => '2022-12-23 10:10:10'
            ], [
                'traveller_id' => 1,
                'city_id' => 3,
                'from_date' => '2022-12-25 10:10:10',
                'to_date' => '2022-12-27 10:10:10'
            ], [
                'traveller_id' => 2,
                'city_id' => 3,
                'from_date' => '2022-12-15 10:10:10',
                'to_date' => '2022-12-18 10:10:10'
            ], [
                'traveller_id' => 1,
                'city_id' => 2,
                'from_date' => '2022-10-15 10:10:10',
                'to_date' => '2022-10-18 10:10:10'
            ], [
                'traveller_id' => 1,
                'city_id' => 3,
                'from_date' => '2022-10-15 10:10:10',
                'to_date' => '2022-10-18 10:10:10'
            ], [
                'traveller_id' => 2,
                'city_id' => 3,
                'from_date' => '2022-10-15 10:10:10',
                'to_date' => '2022-10-18 10:10:10'
            ]
        ];

        foreach($city_travel_data as $data) {
            CityTravelHistory::create($data);
        }

        $this->command->info('End City Travel History Seeder');
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Support\Facades\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Traveler;

class TravelerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Start Traveler Seeder');

        $traveller_data = [
            [
                'traveller_name' => 'Deepak'
            ], [
                'traveller_name' => 'Priya'
            ], [
                'traveller_name' => 'Arun'
            ]
        ];

        foreach($traveller_data as $data) {
            Traveler::create($data);
        }

        $this->command->info('End Traveler Seeder');
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Support\Facades\Log;
use App\Models\Traveler;
use Illuminate\Database\Seeder;

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
                'traveller_name' => 'Deepak',
            ], [
                'traveller_name' => 'Priya',
            ], [
                'traveller_name' => 'Arun',
            ],
        ];

        foreach ($traveller_data as $data) {
            Traveler::create($data);
        }

        $this->command->info('End Traveler Seeder');
    }
}

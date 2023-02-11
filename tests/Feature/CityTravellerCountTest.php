<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityTravellerCountTest extends TestCase
{
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function check_success_user_travel_history_with_from_and_to_dates()
    {
        $attributes = [
            'from_date'  => '2022-12-01',
            'to_date'     => '2022-12-31'
        ];

        $this->get(route('usercitytravelcount', $attributes))
            ->assertStatus(200);
    }


    /**
     * Undocumented function
     * @test
     * @return void
     */
    public function check_failed_user_travel_history_with_inproper_date_format()
    {
        // incorrect dates

        $attributes = [
            'from_date' => '22-8484-7393',
            'to_date' => '33-44-55'
        ];

        $this->get(route('usercitytravelcount', $attributes))
            ->assertStatus(422);

        // Incorrect from-date format

        $attributes = [
            'from_date' => '10-12-2022',
            'to_date' => '2022-12-20'
        ];

        $this->get(route('usercitytravelcount', $attributes))
            ->assertStatus(422);

        // Incorrect to-date format

        $attributes = [
            'from_date' => '2022-12-05',
            'to_date' => '10-12-2022'
        ];

        $this->get(route('usercitytravelcount', $attributes))
            ->assertStatus(422);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function check_falied_user_travel_history_with_from_date_gretaer_than_to_date()
    {
        $attributes = [
            'from_date'  => '2022-12-25',
            'to_date'     => '2022-12-15'
        ];

        $this->get(route('usercitytravelcount', $attributes))
            ->assertStatus(422);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;

class CityTravellerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     *
     * @return void
     */
    public function check_success_user_travel_history_with_from_and_to_dates()
    {
        $attributes = [
            'traveller_id' => 1,
            'from_date'    => '2022-12-01',
            'to_date'      => '2022-12-31',
        ];

        $this->get(route('usercitytravelhistory', $attributes))
            ->assertStatus(200);
    }

    /**
     * Undocumented function.
     *
     * @test
     *
     * @return void
     */
    public function check_success_user_travel_history_without_from_and_to_dates()
    {
        $attributes = [
            'traveller_id' => 1,
        ];

        $this->get(route('usercitytravelhistory', $attributes))
            ->assertStatus(200);
    }

    /**
     * Undocumented function.
     *
     * @test
     *
     * @return void
     */
    public function check_failed_user_travel_history_without_proper_traveller_id()
    {
        $attributes = ['traveller_id' => 'abc'];

        $this->get(route('usercitytravelhistory', $attributes))
            ->assertStatus(404);
    }

    /**
     * Undocumented function.
     *
     * @test
     *
     * @return void
     */
    public function check_failed_user_travel_history_with_inproper_date_format()
    {
        // incorrect dates

        $attributes = [
            'traveller_id' => 1,
            'from_date'    => '22-8484-7393',
            'to_date'      => '33-44-55',
        ];

        $this->get(route('usercitytravelhistory', $attributes))
            ->assertStatus(422);

        // Incorrect from-date format

        $attributes = [
            'traveller_id' => 1,
            'from_date'    => '10-12-2022',
            'to_date'      => '2022-12-20',
        ];

        $this->get(route('usercitytravelhistory', $attributes))
            ->assertStatus(422);

        // Incorrect to-date format

        $attributes = [
            'traveller_id' => 1,
            'from_date'    => '2022-12-05',
            'to_date'      => '10-12-2022',
        ];

        $this->get(route('usercitytravelhistory', $attributes))
            ->assertStatus(422);
    }

    /**
     * Undocumented function.
     *
     * @test
     *
     * @return void
     */
    public function check_failed_user_travel_history_with_from_date_greater_than_to_date()
    {
        $attributes = [
            'traveller_id' => 1,
            'from_date'    => '2022-12-20',
            'to_date'      => '2022-12-10',
        ];

        $this->get(route('usercitytravelhistory', $attributes))
            ->assertStatus(422);
    }
}

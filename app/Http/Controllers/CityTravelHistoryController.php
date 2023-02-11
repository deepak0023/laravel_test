<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\CityTravelHistory;
use App\Models\Traveler;
use Carbon\Carbon;

class CityTravelHistoryController extends Controller
{
    /**
     * Get list of travle history for a user for given optional date period..
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserCityTravelHistory($user_id, Request $request)
    {

        // Validate Input

        $input_data = $request->all();

        $rules = [
            'from_date' => 'date_format:Y-m-d',
            'to_date' => 'date_format:Y-m-d',
        ];

        $custom_error_message = [
            'from_date.date_format' => 'The from date format must be - YYYY-mm-dd',
            'to_date.date_format' => 'The to date format must be - YYYY-mm-dd',
        ];

        $validator = $this->validateInput($input_data, $rules, $custom_error_message);

        if($validator->fails()) {
            return response()->json([
                "status" => "error",
                "errorCode" => "E001",
                "message" => $validator->errors()->first()
            ], 422);
        }

        $traveller = Traveler::where('id', $user_id);

        if(!$traveller->exists()) {
            return response()->json([
                "status"   => "error",
                "errorCode" => "E002",
                "message" => "No traveller with specified id"
            ], 404);
        }

        // Perform logic

        $from_date = $request->input('from_date') ?? null;
        $to_date = $request->input('to_date') ?? null;

        $travel_history = CityTravelHistory::where('traveller_id', $user_id);

        $travel_history = $this->fliterDataBasedOnDate($travel_history, $from_date, $to_date);

        $results = $travel_history->orderBy('from_date')->with('city')->get();

        // Display output based on result data

        if(($results->count() > 0)) {

            $result_array = [];

            foreach($results as $result) {
                array_push($result_array, [
                    'city_name' => $result->city->city_name,
                    'from_date' => $result->from_date,
                    'to_date' => $result->to_date
                ]);
            }

            return response()->json([
                "status" => "success",
                "data"  => $result_array
            ], 200);

        } else {

            return response()->json([
                "status" => "success",
                "data"    => []
            ], 200);

        }

    }


    /**
     * Get list of travle history for unique users with count for given date period.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserCityTravelCount($from_date, $to_date)
    {

        // Validate Input

        $input_data = [
            'from_date' => $from_date,
            'to_date' => $to_date
        ];

        $rules = [
            'from_date' => 'required|date_format:Y-m-d',
            'to_date' => 'required|date_format:Y-m-d',
        ];

        $custom_error_message = [
            'from_date.required' => 'From-date Inputis mandatory',
            'to_date.required' => 'To-date Inputis mandatory',
            'from_date.date_format' => 'The from date format must be - YYYY-mm-dd',
            'to_date.date_format' => 'The to date format must be - YYYY-mm-dd',
        ];

        $validator = $this->validateInput($input_data, $rules, $custom_error_message);

        if($validator->fails()) {
            return response()->json([
                "status" => "error",
                "errorCode" => "E001",
                "message" => $validator->errors()->first()
            ], 422);
        }

        // Perform logic

        $travel_history = CityTravelHistory::selectRaw("distinct cities.city_name as city_name, count(traveller_id) AS traveller_count");

        $travel_history = $this->fliterDataBasedOnDate($travel_history, $from_date, $to_date);

        $results = $travel_history->join('travelers', 'travelers.id', '=', 'traveller_id')
        ->join('cities', 'cities.id', '=', 'city_id')
        ->groupBy('city_name', 'traveller_id')->get();

        // Display output based on result data

        if(($results->count() > 0)) {

            $result_array = [];

            foreach($results as $result) {
                array_push($result_array, [
                    'city_name' => $result->city_name,
                    'traveller_count' => $result->traveller_count,
                ]);
            }

            return response()->json([
                "status" => "success",
                "data"  => $result_array
            ], 200);

        } else {

            return response()->json([
                "status" => "success",
                "data"    => []
            ], 200);

        }

    }

    /**
     * Function to validate Input data based on rules
     *
     * @param [type] $input_data
     * @param [type] $rules
     * @param [type] $custom_error
     * @return $validator object
     */
    private function validateInput($input_data, $rules, $custom_error) {

        $validator = Validator::make($input_data, $rules, $custom_error);

        return $validator;
    }

    /**
     * Function to filter the query based on from and to date
     *
     * @param [type] $query_connection
     * @param [type] $from_date
     * @param [type] $to_date
     * @return [updated] $query_connection object
     */
    private function fliterDataBasedOnDate($query_connection, $from_date, $to_date) {

        switch(true) {

            case (isset($from_date) && isset($to_date)) :

                $query_connection = $query_connection->where(function($query) use ($from_date, $to_date) {
                    $query->where(function($query) use ($from_date, $to_date) {
                        $query->where('from_date', '>=', $from_date)
                        ->where('from_date', '<=', $to_date);
                    });

                    $query->orWhere(function($query) use ($from_date, $to_date) {
                        $query->where('to_date', '>=', $from_date)
                        ->where('to_date', '<=', $to_date);
                    });
                });
                break;

            case (!isset($from_date) && isset($to_date)) :

                $query_connection = $query_connection->where(function($query) use ($from_date, $to_date) {
                    $query->where('from_date', '<=', $to_date)
                    ->orWhere('to_date', '<=', $to_date);
                });
                break;

            case (isset($from_date) && !isset($to_date)) :

                $query_connection = $query_connection->where(function($query) use ($from_date, $to_date) {
                    $query->where('from_date', '<=', $from_date)
                    ->orWhere('to_date', '<=', $from_date);
                });
                break;

            default:
        }

        return $query_connection;
    }
 }

 ?>

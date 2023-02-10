<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\CityTravelHistory;
use App\Models\Traveller;
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
        $validator = Validator::make($request->all(), [
            'from_date' => 'date_format:Y-m-d',
            'to_date' => 'date_format:Y-m-d',
        ], [
            'from_date.date_format' => 'The from date format must be - YYYY-mm-dd',
            'to_date.date_format' => 'The to date format must be - YYYY-mm-dd',
        ]);

        if($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()->first()
            ]);
        }

        $traveller = Traveller::where('id', $user_id);

        if(!$traveller->exists()) {
            return response()->json([
                "status"   => "error",
                "message" => "No traveller with specified id"
            ], 404);
        }

        $travel_history = CityTravelHistory::where('traveller_id', $user_id);

        $from_date = $request->input('from_date') ?? null;
        $to_date = $request->input('to_date') ?? null;

        if(isset($from_date) && isset($to_date)) {
            $travel_history = $travel_history->where(function($query) use ($from_date, $to_date) {
                $query->where(function($query) use ($from_date, $to_date) {
                    $query->where('from_date', '>=', $from_date)
                    ->where('from_date', '<=', $to_date);
                });

                $query->orWhere(function($query) use ($from_date, $to_date) {
                    $query->where('to_date', '>=', $from_date)
                    ->where('to_date', '<=', $to_date);
                });
            });
        }

        if(isset($to_date) && !isset($from_date)) {
            $travel_history = $travel_history->where(function($query) use ($from_date, $to_date) {
                $query->where('from_date', '<=', $to_date)
                ->orWhere('to_date', '<=', $to_date);
            });
        }

        if(isset($from_date) && !isset($to_date)) {
            $travel_history = $travel_history->where(function($query) use ($from_date, $to_date) {
                $query->where('from_date', '<=', $from_date)
                ->orWhere('to_date', '<=', $from_date);
            });
        }

        $results = $travel_history->orderBy('from_date')->with('city')->get();

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
        $filter = [
            'from_date' => $from_date,
            'to_date' => $to_date
        ];

        $validator = Validator::make($filter, [
            'from_date' => 'required|date_format:Y-m-d',
            'to_date' => 'required|date_format:Y-m-d',
        ], [
            'from_date.date_format' => 'The from date format must be - YYYY-mm-dd',
            'to_date.date_format' => 'The to date format must be - YYYY-mm-dd',
        ]);


        if($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()->first()
            ]);
        }

        $travel_history = CityTravelHistory::selectRaw("distinct cities.city_name as city_name, count(traveller_id) AS traveller_count");

        if(isset($from_date) && isset($to_date)) {
            $travel_history = $travel_history->where(function($query) use ($from_date, $to_date) {
                $query->where(function($query) use ($from_date, $to_date) {
                    $query->where('from_date', '>=', $from_date)
                    ->where('from_date', '<=', $to_date);
                });

                $query->orWhere(function($query) use ($from_date, $to_date) {
                    $query->where('to_date', '>=', $from_date)
                    ->where('to_date', '<=', $to_date);
                });
            });
        }

        if(isset($to_date) && !isset($from_date)) {
            $travel_history = $travel_history->where(function($query) use ($from_date, $to_date) {
                $query->where('from_date', '<=', $to_date)
                ->orWhere('to_date', '<=', $to_date);
            });
        }

        if(isset($from_date) && !isset($to_date)) {
            $travel_history = $travel_history->where(function($query) use ($from_date, $to_date) {
                $query->where('from_date', '<=', $from_date)
                ->orWhere('to_date', '<=', $from_date);
            });
        }

        $results = $travel_history->join('travelers', 'travelers.id', '=', 'traveller_id')
        ->join('cities', 'cities.id', '=', 'city_id')
        ->groupBy('city_name', 'traveller_id')->get();

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

 }

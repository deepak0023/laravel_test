<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\CityTravelHistory;
use App\Models\Traveller;

class CityTravelHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
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

        // dd($travel_history->toSql(), $travel_history->getBindings());

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

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'title' => 'required',
    //         'description' => 'required',
    //         'status' => 'required|in:o,h,c,s'
    //     ], [
    //         'title.required' => 'The title param value is required',
    //         'description.required' => 'The description param value is required',
    //         'status.required' => 'The status param value is required',
    //         'status.in' => 'Incorrect status value',
    //     ]);

    //     if($validator->fails()) {
    //         return response()->json([
    //             "message" => $validator->errors()->first()
    //         ]);
    //     }

    //     // Get input values
    //     $data = [
    //         'td_title' => $request->input('title'),
    //         'td_description' => $request->input('description'),
    //         'td_status' => $request->input('status')
    //     ];

    //     $todo = Todo::create($data);

    //     return response()->json([
    //         "message" => "Todo item successfully created",
    //         "data"    => $todo
    //     ], 201);
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     if(Todo::where('td_id', $id)->exists()) {
    //         $todo = Todo::where('td_id', $id)->get();
    //     } else {
    //         return response()->json([
    //             "message" => "No todo item for the mentioned id",
    //             "data" => []
    //         ], 200);
    //     }

    //     return response()->json([
    //         "message" => "success",
    //         "data"    => $todo
    //     ], 200);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'status' => 'required|in:o,h,c,s'
    //     ], [
    //         'status.in' => 'Incorrect status value',
    //     ]);

    //     $data = [];

    //     if(!empty($request->input('title'))) $data['td_title'] = $request->input('title');
    //     if(!empty($request->input('description'))) $data['td_description'] = $request->input('description');
    //     if(!empty($request->input('status'))) $data['td_status'] = $request->input('status');

    //     if(Todo::where('td_id', $id)->exists()) {
    //         Todo::where('td_id', $id)->update($data);
    //     } else {
    //         return response()->json([
    //             "message" => "No todo item for the mentioned id",
    //             "data" => []
    //         ], 200);
    //     }

    //     $todo_data = Todo::where('td_id', $id)->get();

    //     return response()->json([
    //         "message" => "Todo item updated successfully",
    //         "data"    => $todo_data
    //     ], 200);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     if(Todo::where('td_id', $id)->exists()) {
    //         Todo::where('td_id', $id)->delete();
    //     } else {
    //         return response()->json([
    //             "message" => "No todo item for the mentioned id",
    //             "data" => []
    //         ], 200);
    //     }

    //     return response()->json([
    //         "message" => "Todo item deleted successfully",
    //     ], 200);
    // }
}

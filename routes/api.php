<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'namespace'=>'App\Http\Controllers'], function() {
    Route::get('/travel_history/{traveller_id}', 'CityTravelHistoryController@getUserCityTravelHistory')->name('usercitytravelhistory');
    Route::get('/travel_count/{from_date}/{to_date}', 'CityTravelHistoryController@getUserCityTravelCount')->name('usercitytravelcount');
});

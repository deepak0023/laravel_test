<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityTravelHistory extends Model
{
    /**
     * Table to be connected
     */
    protected $table = 'city_travel_history';

    /**
     *  Disable created at and updated at timestamp
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'city_id',
        'travel_id',
        'from_date',
        'to_date',
    ];
}

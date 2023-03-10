<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * Table to be connected.
     */
    protected $table = 'cities';

    /**
     *  Disable created at and updated at timestamp.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'city_name',
    ];

    public function cityTravelHistory()
    {
        return $this->hasMany(CityTravelHistory::class, 'city_id', 'id');
    }
}

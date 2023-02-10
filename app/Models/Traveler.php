<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traveler extends Model
{
    /**
     * Table to be connected
     */
    protected $table = 'travelers';

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
        'traveller_name',
    ];
}

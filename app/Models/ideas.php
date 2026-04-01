<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class idea extends Model
{
    //

    protected $fillable = [
        'title',
        'description',
        'funding_goal',
        'current_amount',
        'user_id',

    ];
}

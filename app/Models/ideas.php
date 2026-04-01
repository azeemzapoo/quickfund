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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pledges()
    {
        return $this->hasMany(Pledge::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}

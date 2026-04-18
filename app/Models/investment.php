<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
        'amount',
        'user_id',
        'idea_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }
}

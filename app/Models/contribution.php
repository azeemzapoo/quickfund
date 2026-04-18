<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = [
        'role',
        'user_id',
        'idea_id',
    ];

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

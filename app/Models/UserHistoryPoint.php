<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHistoryPoint extends Model
{
    protected $fillable = [
        'user_id',
        'point',
        'description',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

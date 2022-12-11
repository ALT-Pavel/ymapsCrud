<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Markers extends Model
{

    protected $fillable = [
        'name',
        'user_id',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

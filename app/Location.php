<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['location_lat', 'location_long'];

    public function users() {
        return $this->belongsToMany('App\User', 'user_location', 'location_id', 'user_id')->withTimestamps();
    }
}

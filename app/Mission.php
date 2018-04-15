<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $fillable = ['title', 'description', 'starts_at', 'ends_at', 'status'];

    public function users() {
        return $this->belongsToMany('App\User', 'user_mission')->withTimestamps();
    }

    public function HasAdmin() {
        return $this->belongsTo('App\User');
    }
}

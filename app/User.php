<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'prenom', 'login', 'password', 'age', 'role', 'num_tel', 'status', 'mission_id'
    ];
    public function electeurs () {
        return $this->belongsToMany('App\Electeur', 'user_electeur', 'user_id', 'electeur_id')->withTimestamps();
    }

    public function missions() {
        return $this->belongsToMany('App\Mission', 'user_mission')->withTimestamps();
    }

    public function addMissions() {
        return $this->hasMany('App\Mission');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'password'
    ];
}

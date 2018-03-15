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
        'nom', 'prenom', 'login', 'password', 'age', 'role', 'num_tel'
    ];
    public function Electeurs () {
        return $this->belongsToMany('App\Electeur', 'user_electeur', 'user_id', 'electeur_id')->withTimestamps();
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

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Electeur extends Model
{
    protected $fillable = ['nom', 'prenom', 'prenom_pere', 'prenom_grand_pere','age', 'centre_de_vote', 'situation_familiale', 'situation_pro', 'isElecteur', 'orientation_de_vote', 'intention_de_vote', 'adresse', 'niveau_academique', 'remarque', 'num_tel'];

    public function users() {
        return $this->belongsToMany('App\User', 'user_electeur', 'electeur_id', 'user_id')->withTimestamps();
    }
}

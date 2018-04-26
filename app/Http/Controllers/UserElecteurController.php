<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use DB;
use App\User;
use App\Electeur;

class UserElecteurController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function getFormsLocations(){
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'admin') {
            return response()->json(['msq' => 'User Not Found'], 404);
        }
        $userElecteur = DB::table('user_electeur')->get();
        foreach ($userElecteur as $elem) {
            $user = (new User())->find($elem->user_id);
            $electeur = (new Electeur())->find($elem->electeur_id);
            $elem->user = $user;
            $elem->electeur = $electeur;
        }
        return response()->json(json_decode(json_encode($userElecteur), true), 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use DB;
use App\User;

class UserMissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function getAgentsPerMission(Request $request) {
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'admin') {
            return response()->json(['msq' => 'User Not Found'], 404);
        }
        $starts_at = $request->input('starts_at');
        $ends_at = $request->input('ends_at');

        $result = DB::table('user_mission')
            ->whereBetween('created_at', [$starts_at, $ends_at])
            ->orderBy('created_at', 'asc')
            ->get();
        foreach ($result as $elem) {
            $user  = (new User())->find($elem->user_id);
            $elem->user = $user;
        }
        // print_r($result);
        return response()->json(json_decode(json_encode($result)), 200);
    }

    public function addLocation(Request $request) {
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'agent') {
            return response()->json(['msq' => 'User Not Found'], 404);
        }
        $latitude = $request->input('location_lat');
        $longitude = $request->input('location_long');

        // $user->missions
        $idInserted = DB::table('user_mission')->insertGetId([
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
            "location_lat" => $latitude,
            "location_long" => $longitude,
            "user_id" => $user->id
        ]);
        if (! empty($idInserted)) {
            return response()->json(['msg' => 'Location Added'], 200);
        } else {
            return response()->json(['msg' => 'Erreur'], 404);
        }

    }
}

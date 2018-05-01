<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Location;
class UserLocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function submitLocation(Request $request) {
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'agent') {
            return response()->json(['msq' => 'User Not Found'], 401);
        }
        $location_lat = $request->input('location_lat');
        $location_long = $request->input('location_long');
        $location = new Location([
            "location_lat" => $location_lat,
            "location_long" => $location_long
        ]);

        if ($location->save()) {
            $location->users()->attach($user->id);
            return response()->json(["msg" => "Location Submitted"], 200);
        } else {
            return response()->json(["msg" => "Erreur"], 404);
        }

    }
}

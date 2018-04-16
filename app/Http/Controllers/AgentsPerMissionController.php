<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use JWTAuth;

class AgentsPerMissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'admin') {
            return response()->json(['msq' => 'User Not Found'], 404);
        }
        $starts_at = $request->input('starts_at');
        $ends_at = $request->input('ends_at');

        $result = DB::table('user_mission')
            ->whereBetween('created_at', [$starts_at, $ends_at])
            ->orderBy('created_at', 'asc')
            ->get();

        // print_r($result);
        return response()->json(json_decode(json_encode($result)), 200);
    }
}

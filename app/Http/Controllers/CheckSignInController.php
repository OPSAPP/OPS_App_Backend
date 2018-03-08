<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class CheckSignInController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }


    public function index() {
        try {
            if(! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['msq' => 'user undfined'], 401);
            } else {
                return response()->json(['msg' => 'user connected', 'user' => $user], 200);
            }
        } catch(JWTException $e) {
            return response()->json(['msg' => 'Could Not get User'], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*try {
            if(! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['msq' => 'user undfined'], 401);
            } else {
                return response()->json(['msg' => 'user connected', 'user' => $user], 200);
            }
        } catch(JWTException $e) {
            return response()->json(['msg' => 'Could Not get User'], 500);
        }*/

    }

}

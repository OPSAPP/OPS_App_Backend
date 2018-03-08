<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use Illuminate\Support\Facades\Hash;
use DB;
class SignInController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $credentials = $request->only('login', 'password', 'role');

        try {
            if(! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['msg' => 'Invalid Credentials'], 401);
            }
        } catch(JWTException $e) {
            return response()->json(['msg' => 'Could not created Token'], 500);
        }
        return response()->json(['token' => $token, 'user' => JWTAuth::toUser($token)], 200);
    }

}

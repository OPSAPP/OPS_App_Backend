<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mission;
use JWTAuth;

class AuthentificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ["only" => ['checkSignIn']]);
    }

    public function signIn(Request $request) {
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

    public function checkSignIn() {
        try {
            if(! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['msq' => 'user undefined'], 401);
            } else {
                if($user->role == 'agent' && $user->status == 'occupé') {
                    $mission = (new Mission())->find($user->mission_id);
                    $user->mission_details = $mission;
                }
                return response()->json(['msg' => 'user connected', 'user' => $user], 200);
            }
        } catch(JWTException $e) {
            return response()->json(['msg' => 'Could Not get User'], 500);
        }

    }
}

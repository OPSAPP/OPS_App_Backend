<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function getAdmins() {
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'admin') {
            return response()->json(['msq' => 'User Not Found'], 404);
        }
        $adminsArray = (new User())->where('role', '=', 'admin')->get();
        if(sizeof(json_decode(json_encode($adminsArray, true))) > 0) {
            return response()->json([json_decode(json_encode($adminsArray, true))], 200);
        } else {
            $array = [
                "msg" => "Pas d'agent trouvé"
            ];
            return response()->json($array, 200);
        }
    }

    public function addAdmin(Request $request) {
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'admin') {
            return response()->json(['msq' => 'User Not Found'], 404);
        }
        $nom = $request->input('nom');
        $prenom = $request->input('prenom');
        $login = $request->input('login');
        $password = $request->input('password');
        $role = 'agent';

        $admin = new User([
            "nom" => $nom,
            "prenom" => $prenom,
            "login" => $login,
            "password" => Hash::make($password),
            "role" => $role
        ]);
        if ($admin->save()) {
            $array = [
                "msg" => "Agent ajouté",
                "data" => $admin
            ];
            return response()->json($array, 200);
        } else {
            $array = [
                "msg" => "Agent non Ajouté"
            ];
            return response()->json($array, 404);
        }
    }
}

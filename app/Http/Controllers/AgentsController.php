<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class AgentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function getAgents() {
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'admin') {
            return response()->json(['msq' => 'User Not Found'], 404);
        }
        $agentsArray = (new User())->where('role', '=', 'agent')->get();
        if(sizeof(json_decode(json_encode($agentsArray, true))) > 0) {
            return response()->json(json_decode(json_encode($agentsArray, true)), 200);
        } else {
            $array = [
                "msg" => "Pas d'agent trouvé"
            ];
            return response()->json($array, 200);
        }
    }

    public function addAgent(Request $request) {
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'admin') {
            return response()->json(['msq' => 'User Not Found'], 404);
        }
        $nom = $request->input('nom');
        $prenom = $request->input('prenom');
        $login = $request->input('login');
        $password = $request->input('password');
        $role = 'agent';

        $agent = new User([
            "nom" => $nom,
            "prenom" => $prenom,
            "login" => $login,
            "password" => Hash::make($password),
            "role" => $role
        ]);
        if ($agent->save()) {
            $array = [
                "msg" => "Agent ajouté",
                "data" => $agent
            ];
            return response()->json($array, 200);
        } else {
            $array = [
                "msg" => "Agent non Ajouté"
            ];
            return response()->json($array, 404);
        }

    }

    public function getAgentById($id) {
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'admin') {
            return response()->json(['msq' => 'User Not Found'], 404);
        }
        $agent = (new User())->find($id);
        $array = [
            "msg" => "Agent trouvé",
            "data" => $agent
        ];

        return response()->json($array, 200);
    }

    public function updateAgent(Request $request, $id) {
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'admin') {
            return response()->json(['msq' => 'User Not Found'], 404);
        }
        $agent = (new User())->find($id);
        $nom = $request->input('nom');
        $prenom = $request->input('prenom');
        $login = $request->input('login');
        $password = $request->input('password');
        if ($agent->update([
            "nom" => $nom,
            "prenom" => $prenom,
            "login" => $login,
            "password" => Hash::make($password)
        ])) {
            $array = [
                "msg" => "Agent mis à jours",
                "data" => $agent
            ];
                return response()->json($array, 200);
        } else {
            return response()->json(["msg"=>"Erreur dans l'ajout"], 404);
        }

    }
}

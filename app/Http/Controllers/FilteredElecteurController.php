<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use App\Electeur;
use DB;
class FilteredElecteurController extends Controller
{
    public function __construct()
    {
        // $this->middleware('jwt.auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* if(! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['msg' => 'User Not Found'], 404);
        }*/
        $nom = $request->input('nom');
        $prenom = $request->input('prenom');
        $prenom_grand_pere = $request->input('prenom_grand_pere');

        if (isset($nom) && $nom != null) {
            if (isset($prenom) && $prenom != null) {
                if (isset($prenom_grand_pere) && $prenom_grand_pere != null) {

                } else {
                    $databasePrenomGPArray = DB::table('electeurs')
                        ->select(DB::raw('prenom_grand_pere'))
                        ->where([
                            ["nom", "=", $nom],
                            ["prenom", "=", $prenom]
                        ])
                        ->get();
                    $array = array_map(function($element) {
                        return $element['prenom_grand_pere'];
                    }, json_decode(json_encode($databasePrenomGPArray), true));
                    return response()->json($this->getFilteredArray($array), 200);
                }

            } else {
                $databasePrenomArray = DB::table('electeurs')
                    ->select(DB::raw('prenom'))
                    ->where('nom', '=', $nom)
                    ->get();
                $array = array_map(function($element) {
                    return $element['prenom'];
                }, json_decode(json_encode($databasePrenomArray), true));
                return response()->json($this->getFilteredArray($array), 200);
                // print_r(json_decode(json_encode($databasePrenomArray), true));
            }
        } else {
            $databaseNomArray = Electeur::all();
            $array = array_map(function($element) {
                return $element['nom'];
            }, $databaseNomArray->toArray());
            return response()->json($this->getFilteredArray($array), 200);
        }

    }

    /**
     * @param $array
     * @return array
     */
    public function getFilteredArray($array) {
        $filteredArray = [];
        foreach ($array as $element) {
            if (! in_array(strtolower($element), $filteredArray)) {
                $filteredArray[] = strtolower($element);
            }
        }
        return $filteredArray;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Electeur;
use JWTAuth;
use App\User;
class ElecteurController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['only' => 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Electeur::all();
        $array = [
            "data" => $data
        ];
        return response()->json($data, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(! $user = JWTAuth::parseToken()->authenticate()) {
           return response()->json(['msq' => 'User Not Found'], 404);
        }
        $nom = $request->input("nom");
        $prenom = $request->input("prenom");
        $prenom_pere = $request->input("prenom_pere");
        $prenom_grand_pere = $request->input("prenom_grand_pere");
        $age = $request->input("age");
        $adresse = $request->input("adresse");
        $num_tel = $request->input("num_tel");
        $niveau_academique = $request->input("niveau_academique");
        $situation_familiale = $request->input("situation_familiale");
        $situation_pro = $request->input("situation_pro");
        $isElecteur = $request->input("isElecteur");
        $centre_de_vote = $request->input("centre_de_vote");
        $intention_de_vote = $request->input("intention_de_vote");
        $orientation_de_vote = $request->input("orientation_de_vote");
        $remarque = $request->input("remarque");

        $electeur_id = $request->input("electeur_id");
        // $user_id = $request->input("user_id");
        $user_id = $user->id;

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        // Fill Information with Corresponded

        //if($electeur_id != null) {
            // $electeur = DB::table('electeurs')->where('id', $electeur_id);
        if(isset($electeur_id) && $electeur_id != null) {
            $electeur = Electeur::where('id', $electeur_id)->first();
            $msg = "Electeur Modifié";
        } else {
            $electeur = new Electeur();
            $msg = "Electeur ajouté";
        }

            $electeur->nom = $nom;
            $electeur->prenom = $prenom;
            $electeur->prenom_pere = $prenom_pere;
            $electeur->prenom_grand_pere = $prenom_grand_pere;
            $electeur->age = $age;
            $electeur->adresse = $adresse;
            $electeur->num_tel = $num_tel;
            $electeur->niveau_academique = $niveau_academique;
            $electeur->situation_familiale = $situation_familiale;
            $electeur->situation_pro = $situation_pro;
            $electeur->isElecteur = $isElecteur;
            $electeur->centre_de_vote = $centre_de_vote;
            $electeur->intention_de_vote = $intention_de_vote;
            $electeur->orientation_de_vote = $orientation_de_vote;
            $electeur->remarque = $remarque;
            if($electeur->save()){
                $code = 200;
                $array = [
                    "msg" => $msg,
                    "data" => $electeur
                ];
                $electeur->User()->attach($user_id, [
                    'location_lat' => $latitude,
                    'location_long' => $longitude
                ]);
                // Add the attach method to the Many-To-Many Relation, use [] to specify location_lat and location_long
            } else {
                $code = 404;
                $array = [
                    "msg" => "Electeur non modifié"
                ];
            }

            return response()->json($array, $code);
        /*} else {
            $electeur = new Electeur();
            $electeur->nom = $nom;
            $electeur->prenom = $prenom;
            $electeur->prenom_pere = $prenom_pere;
            $electeur->prenom_grand_pere = $prenom_grand_pere;
            $electeur->age = $age;
            $electeur->adresse = $adresse;
            $electeur->num_tel = $num_tel;
            $electeur->niveau_academique = $niveau_academique;
            $electeur->situation_familiale = $situation_familiale;
            $electeur->situation_pro = $situation_pro;
            $electeur->isElecteur = $isElecteur;
            $electeur->centre_de_vote = $centre_de_vote;
            $electeur->intention_de_vote = $intention_de_vote;
            $electeur->orientation_de_vote = $orientation_de_vote;
            $electeur->remarque = $remarque;
            // Add Electeur to Database

            if($electeur->save()) {
                $array = [
                    "msg" => "user added",
                    "data" => $electeur
                ];

                return response()->json($array, 200);
            }

        }*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $electeur = Electeur::find($id);
        return response()->json($electeur, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

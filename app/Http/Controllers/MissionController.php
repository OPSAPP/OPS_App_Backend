<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use App\Mission;
use Carbon\Carbon;
class MissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ["only" => ['index', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'admin') {
            return response()->json(['msg' => 'User Not Found'], 404);
        }
        $data = Mission::all();
        return response()->json($data, 200);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'admin') {
            return response()->json(['msq' => 'User Not Found'], 404);
        }
        $title = $request->input('title');
        $description = $request->input('description');
        $start_day_of_month = $request->input('start_day_of_month');
        $start_month = $request->input('start_month');
        $start_year = $request->input('start_year');
        $start_hour = $request->input('start_hour');
        $start_minutes = $request->input("start_minutes");
        $end_day_of_month = $request->input('end_day_of_month');
        $end_month = $request->input('end_month');
        $end_year = $request->input('end_year');
        $end_hour = $request->input('end_hour');
        $end_minutes = $request->input('end_minutes');
        $starts_at = Carbon::createFromFormat('Y-m-d H:i','' . $start_year .'-' .$start_month . '-' . $start_day_of_month. ' ' . $start_hour . ':' . $start_minutes . '');
        $ends_at = Carbon::create($end_year, $end_month, $end_day_of_month, $end_hour, $end_minutes, 0, 'Europe/London');
        $userArray = $request->input('agents');
        $mission = new Mission([
           "title" => $title,
           "description" => $description,
           "starts_at" => $starts_at,
           "ends_at" => $ends_at
        ]);
            if($user->addMissions()->save($mission)) {
                $approvedUsers = [];
                foreach ($userArray as $elem) {
                    $reqUser = User::find($elem["user_id"]);
                    if ($reqUser->status == 'disponible') {
                        $reqUser->status = "occupé";
                        $reqUser->mission_id = $mission->id;
                        if($reqUser->save()) {
                            $mission->users()->attach($reqUser->id);
                            $approvedUsers[] = $reqUser;
                        }
                    } else {
                        $declinedUsers[] = $reqUser;
                    }
                }
                if(sizeof($approvedUsers) > 0){
                    $rsp = [
                        "msg" => "Mission Added",
                        "data" => [
                            "missionData" => $mission,
                            "approvedUsers" => $approvedUsers,
                            "declinedUsers" => $declinedUsers
                        ]
                    ];
                    return response()->json($rsp, 200);
                } else {

                    try {
                        $mission->delete();
                        $rsp = [
                            "msg" => "Mission not Added, there is no Available Agents"
                        ];
                        return response()->json($rsp, 404);
                    } catch (\Exception $e) {

                    }


                }
            }


        /*
            This method wil analyse the agent id and get the Available agents to match them with the correspondent Mission.
            If An Error Occur, The Agent in Question will be sent to the Fail Object and a Message will be Displayed in the Front End.

            The User Model must be updated with a two new attributes: status and current_mission :
            status will take two possible values : 'disponible' or ' occupe'
            current_mission wil take the id of the Current affected mission
            A User Controller must be added in order to fetch the User Data to get the Current Mission
        */

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

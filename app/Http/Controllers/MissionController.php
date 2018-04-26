<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use App\Mission;
use Carbon\Carbon;
use DB;
use App\Jobs\StartJob;
use App\Jobs\EndJob;
class MissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ["only" => ['index', 'store', 'update', 'destroy']]);
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
        $status = $request->input('status');
        $starts_at = Carbon::createFromFormat('Y-m-d H:i','' . $start_year .'-' .$start_month . '-' . $start_day_of_month. ' ' . $start_hour . ':' . $start_minutes . '');
        $ends_at = Carbon::create($end_year, $end_month, $end_day_of_month, $end_hour, $end_minutes);
        // $userArray = $request->input('agents');
        $mission = new Mission([
           "title" => $title,
           "description" => $description,
           "starts_at" => $starts_at,
           "ends_at" => $ends_at,
            'status' => $status
        ]);
        // echo (strtotime($mission->starts_at) - strtotime(date('Y-m-d H:i'))) .'   ' . strtotime(date('Y-m-d H:i'));
        // echo strtotime($starts_at->format('Y-m-d H:i'));
        if ($this->isMissionValid($mission)) {
            if ($user->addMissions()->save($mission)) {
                $startTimestamp = strtotime($mission->starts_at) - strtotime($mission->created_at);
                $endTimestamp = strtotime($mission->ends_at) - strtotime($mission->created_at);
                $array = [
                    "msg" => "Mission Added",
                    "data" => $mission,
                    "start" => $startTimestamp,
                    "end" => $endTimestamp
                ];
                $startJob = (new StartJob($mission))->delay($startTimestamp);
                $endJob = (new EndJob($mission))->delay($endTimestamp);

                dispatch($startJob);
                dispatch($endJob);
                return response()->json($array, 200);
            } else {
                return response()->json(["msg" => "Mission non ajoutée"], 404);
            }
        } else {
            return response()->json(["msg" => "Mission non ajoutée"], 404);
        }

    }

    public function isMissionValid($mission) {
        $missionsResult = DB::table('missions')
            ->where([
                ["starts_at", ">", $mission->starts_at],
                ["starts_at", "<", $mission->ends_at],
                ["ends_at", ">", $mission->starts_at],
                ["ends_at", "<", $mission->ends_at]
            ])
            ->orWhereBetween("starts_at", [$mission->starts_at, $mission->ends_at])
            ->orWhereBetween("ends_at", [$mission->starts_at, $mission->ends_at])
            ->get();
        if (sizeof(json_decode(json_encode($missionsResult))) != 0) {
            return false;
        } else {
            return true;
        }
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
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'admin') {
            return response()->json(['msq' => 'User Not Found'], 404);
        }
        $mission = (new Mission())->find($id);
        if ($mission->status === 'planifiée' && $mission->user_id === $user->id) {
            $title = $request->input('title');
            $description = $request->input('description');
            /*$start_day_of_month = $request->input('start_day_of_month');
            $start_month = $request->input('start_month');
            $start_year = $request->input('start_year');
            $start_hour = $request->input('start_hour');
            $start_minutes = $request->input("start_minutes");
            $end_day_of_month = $request->input('end_day_of_month');
            $end_month = $request->input('end_month');
            $end_year = $request->input('end_year');
            $end_hour = $request->input('end_hour');
            $end_minutes = $request->input('end_minutes');
            $status = $request->input('status');
            $starts_at = Carbon::createFromFormat('Y-m-d H:i','' . $start_year .'-' .$start_month . '-' . $start_day_of_month. ' ' . $start_hour . ':' . $start_minutes . '');
            $ends_at = Carbon::create($end_year, $end_month, $end_day_of_month, $end_hour, $end_minutes, 0);*/

            if ($mission->update([
                'title' => $title,
                'description' => $description,
                /*'starts_at' => $starts_at,
                'ends_at' => $ends_at,
                'status' => $status*/
            ])) {
                $array = [
                    "msg" => "Mission modifiée"
                ];
                /*$startTimestamp = strtotime($mission->starts_at) - strtotime($mission->updated_at);
                $endTimestamp = strtotime($mission->ends_at) - strtotime($mission->updated_at);
                $array = [
                    "msg" => "Mission Added",
                    "data" => $mission,
                    "start" => $startTimestamp,
                    "end" => $endTimestamp
                ];
                $startJob = (new StartJob($mission))->delay($startTimestamp);
                $endJob = (new EndJob($mission))->delay($endTimestamp);

                dispatch($startJob);
                dispatch($endJob);*/
                return response()->json($array, 200);
            }

        } else {
            $array = [
                "msg" => "Erreur dans la mise à jour de la Mission, vérifiez l'état"
            ];
            return response()->json($array, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        if((! $user = JWTAuth::parseToken()->authenticate()) || $user->role != 'admin') {
            return response()->json(['msq' => 'User Not Found'], 404);
        }
        $mission = (new Mission())->find($id);
        if ($mission->delete()) {
            return response()->json(["msg" => "Mission Deleted"], 200);
        } else {
            return response()->json(['msg' => 'Error'], 404);
        }
    }
}

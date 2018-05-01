<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('electeurs', 'ElecteurController', [
    'only' => ['store', 'index', 'show', 'update']
]);
/*Route::resource('signIn', 'SignInController', [
    'only' => ['store']
]);
Route::resource('checkSignIn', 'CheckSignInController', [
    'only' => ['index']
]);*/
Route::resource('missionControl', 'MissionController');
/*Route::resource('filteredElecteur', 'FilteredElecteurController', [
    'only' => ['store']
]);*/
/*Route::resource('getFormsLocations', 'FormsLocationsController', [
    "only" => ['index']
]);*/
Route::get('formsLocations', [
    "uses" => 'UserElecteurController@getFormsLocations',
    "as" => "formsLocations"
]);
Route::post('agentsPerMission', [
    "uses" => "UserMissionController@getAgentsPerMission",
    "as" => "agentsPerMission"
]);
Route::post('/addLocation', [
    "uses" => "UserMissionController@addLocation",
    "as" => "addLocation"
]);
/*Route::resource('getAgentsPerMission', 'AgentsPerMissionController', [
    "only" => ['store']
]);*/
Route::post('/signIn', [
    "uses" => "AuthentificationController@signIn",
    "as" => "signIn"
]);
Route::get('/checkSignIn', [
    "uses" => "AuthentificationController@checkSignIn",
    "as" => "checkSignIn"
]);

Route::get('getAgents', [
    "uses" => "AgentsController@getAgents",
    "as" => "getAgents"
]);
Route::post('addAgent', [
    "uses" => "AgentsController@addAgent",
    "as" => "addAgent"
]);
Route::get('getAgent/{id}', [
    "uses" => "AgentsController@getAgentById",
    "as" => "getAgent"
]);

Route::put('updateAgent/{id}', [
    "uses" => "AgentsController@updateAgent",
    "as" => "updateAgent"
]);
Route::post('submitLocation', [
    "uses" => "UserLocationController@submitLocation",
    "as" => "submitLocation"
]);

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
    'only' => ['store', 'index', 'show']
]);
Route::resource('signIn', 'SignInController', [
    'only' => ['store']
]);
Route::resource('checkSignIn', 'CheckSignInController', [
    'only' => ['index']
]);
Route::resource('missionControl', 'MissionController');
Route::resource('filteredElecteur', 'FilteredElecteurController', [
    'only' => ['store']
]);
Route::resource('getFormsLocations', 'FormsLocationsController', [
    "only" => ['index']
]);

Route::resource('getAgentsPerMission', 'AgentsPerMissionController', [
    "only" => ['store']
]);

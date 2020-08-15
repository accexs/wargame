<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('warmodule/army', 'ArmyController@create');
Route::get('warmodule/army', 'ArmyController@index');
Route::put('warmodule/army/{army_id}/unit/{unit_id}/train',
    'ArmyController@trainUnit');
Route::put('warmodule/army/{army_id}/unit/{unit_id}/transform',
    'ArmyController@transformUnit');
Route::post('warmodule/battle', 'BattleController@battle');

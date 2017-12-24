<?php

use Illuminate\Http\Request;

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


Route::post('/log/new','LogController@newLog');
Route::post('/log/update/','LogController@updateLogStatus');
Route::get('/log/today/','LogController@getTodayLog');
Route::get('/log/today/report','LogController@getTodayReport');
Route::get('/log/today/report-total','LogController@getTodayReportTotal');

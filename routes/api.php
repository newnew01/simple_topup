<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');


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



/***************************************/
Route::middleware(['auth:api'])->group(function () {
    Route::post('/wepay/balance', 'WepayController@getBalance');

    Route::post('/wepay/refund', 'WepayController@refund');

    Route::post('/wepay/topup', 'WepayController@topup');

    Route::post('/wepay/get-operator', 'WepayController@getOperator');

    Route::post('/wepay/topup-status', 'WepayController@getTopupStatus');

    Route::post('/log/today/','LogController@getTodayLog');
    Route::post('/log/today/report','LogController@getTodayReport');
    Route::post('/log/today/report-total','LogController@getTodayReportTotal');

    Route::post('/log/monthly/report','LogController@getMonthlyReport');
    Route::post('/log/monthly/report-total','LogController@getMonthlyReportTotal');

    Route::post('/log/entire/report-total','LogController@getEntireReportTotal');
    Route::post('/log/entire/report','LogController@getEntireReport');
});

Route::post('/wepay/callback/topup', 'WepayController@callbackTopup');

Route::post('/wepay/callback/refund',  'WepayController@callbackRefund');
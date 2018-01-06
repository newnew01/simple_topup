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


Route::post('/log/new','LogController@newLog');
Route::post('/log/update/','LogController@updateLogStatus');
Route::get('/log/today/','LogController@getTodayLog');
Route::get('/log/today/report','LogController@getTodayReport');
Route::get('/log/today/report-total','LogController@getTodayReportTotal');

Route::get('/log/monthly/report','LogController@getMonthlyReport');
Route::get('/log/monthly/report-total','LogController@getMonthlyReportTotal');

Route::get('/log/entire/report-total','LogController@getEntireReportTotal');
Route::get('/log/entire/report','LogController@getEntireReport');




Route::post('/balance', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    $client = new GuzzleHttp\Client();
    $response = $client->request('POST', 'https://api.easysoft.in.th/topup/v2.php', [
        'form_params' => [
            'username' => $username,
            'password' => $password,
            'amount' => '1',
        ]
    ]);
    $xml=new SimpleXMLElement($response->getBody()->getContents());
    echo json_encode($xml);
});

Route::post('/network_status', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    $client = new GuzzleHttp\Client();
    $response = $client->request('POST', 'https://api.easysoft.in.th/topup/v2.php', [
        'form_params' => [
            'username' => $username,
            'password' => $password,
            'online' => '1',
        ]
    ]);
    $xml=new SimpleXMLElement($response->getBody()->getContents());
    echo json_encode($xml);
});

Route::post('/topup_status', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');
    $orderid = $request->input('orderid');

    $client = new GuzzleHttp\Client();
    $response = $client->request('POST', 'https://api.easysoft.in.th/topup/v2.php', [
        'form_params' => [
            'username' => $username,
            'password' => $password,
            'mobile' => 'update',
            'orderid' => $orderid
        ]
    ]);
    $xml=new SimpleXMLElement($response->getBody()->getContents());
    echo json_encode($xml);
});

Route::post('/cancel_topup', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');
    $orderid = $request->input('orderid');

    $client = new GuzzleHttp\Client();
    $response = $client->request('POST', 'https://api.easysoft.in.th/topup/v2.php', [
        'form_params' => [
            'username' => $username,
            'password' => $password,
            'mobile' => 'return',
            'orderid' => $orderid
        ]
    ]);
    $xml=new SimpleXMLElement($response->getBody()->getContents());
    echo json_encode($xml);
});

Route::post('/topup_refill', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');
    $network = $request->input('network');
    $number = $request->input('number');
    $cash = $request->input('cash');
    $users = $request->input('users');

    $client = new GuzzleHttp\Client();
    $response = $client->request('POST', 'https://api.easysoft.in.th/topup/v2.php', [
        'form_params' => [
            'username' => $username,
            'password' => $password,
            'mobile' => 'refill',
            'network' => $network,
            'number' => $number,
            'cash' => $cash,
            'users' => $users
        ]
    ]);
    $xml=new SimpleXMLElement($response->getBody()->getContents());
    echo json_encode($xml);
});


Route::get('/line-notify/report-today','LineController@notifyReportToday');
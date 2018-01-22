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




Route::get('/wepay/balance', function () {

    $username = env("WEPAY_USERNAME");
    $password = env("WEPAY_PASSWORD");

    $client = new GuzzleHttp\Client();
    try {
        $response = $client->request('POST', 'https://www.wepay.in.th/client_api.json.php', [
            'form_params' => [
                'username' => $username,
                'password' => $password,
                'type' => 'balance_inquiry',
            ]
        ]);

        return $response;

    } catch (\GuzzleHttp\Exception\RequestException $e) {
        $data = json_decode($e->getResponse()->getBody(true));
        return Response::json($data);
        //return json_decode($e->getResponse()->getBody(true));
    }



});

/***************************************/

Route::get('/wepay/balance', 'WepayController@getBalance');

Route::get('/wepay/topup', 'WepayController@topup');

Route::get('/wepay/callback/topup', 'WepayController@callbackTopup');

Route::get('/wepay/callback/refund',  'WepayController@callbackRefund');

Route::get('/wepay/test', function () {
    $username = env("WEPAY_USERNAME");
    $password = env("WEPAY_PASSWORD");

    $client = new GuzzleHttp\Client();
    try {
        $response = $client->request('POST', 'https://www.wepay.in.th/client_api.json.php', [
            'form_params' => [
                'username' => $username,
                'password' => $password,
                'type' => 'balance_inquiry',
            ]
        ]);

        return $response;

    } catch (\GuzzleHttp\Exception\RequestException $e) {
        $data = json_decode($e->getResponse()->getBody(true));
        return Response::json($data);
        //return json_decode($e->getResponse()->getBody(true));
    }
});

//username=test&password=test&resp_url=https://www.mywebsite.com/wepay_result.php&dest_ref=MTOP
//UP12345&pay_to_amount=10&pay_to_company=12CALL&type=mtopup&pay_to_ref1=0812345678

//Route::get('/line-notify/report-today','LineController@notifyReportToday');
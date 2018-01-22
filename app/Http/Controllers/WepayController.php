<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class WepayController extends Controller
{
    public function getBalance()
    {
        $username = env("WEPAY_USERNAME");
        $password = env("WEPAY_PASSWORD");

        $client = new Client();
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
    }

    public function topup(Request $request)
    {
        $username = env("WEPAY_USERNAME");
        $password = env("WEPAY_PASSWORD");
        $type = 'mtopup';
        $resp_url = 'http://topup.newphone-function.trade/api/wepay/callback/topup';
        $dest_ref = 'MTOPUP';
        $pay_to_ref1 = $request->input('number');;
        $pay_to_amount = $request->input('cash');
        $pay_to_company = $request->input('network');


        $client = new Client();
        try {
            return 1;
            $response = $client->request('POST', 'https://www.wepay.in.th/client_api.json.php', [
                'form_params' => [
                    'username' => $username,
                    'password' => $password,
                    'type' => $type,
                    'resp_url' => $resp_url,
                    'dest_ref' => $dest_ref,
                    'pay_to_ref1' => $pay_to_ref1,
                    'pay_to_amount' => $pay_to_amount,
                    'pay_to_company' => $pay_to_company,
                ]
            ]);

            return $response;

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $data = json_decode($e->getResponse()->getBody(true));
            return Response::json($data);
            //return json_decode($e->getResponse()->getBody(true));
        }
    }

    public function callbackTopup()
    {

    }

    public function callbackRefund()
    {

    }


}

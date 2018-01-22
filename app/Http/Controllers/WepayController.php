<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\TopupLog;
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

            echo $response->code;

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            //$data = json_decode($e->getResponse()->getBody(true));
            //return Response::json($data);
            //return json_decode($e->getResponse()->getBody(true));

            return $e->getResponse()->getBody(true);
        }
    }

    public function topup(Request $request)
    {
        $username = env("WEPAY_USERNAME");
        $password = env("WEPAY_PASSWORD");
        $type = 'mtopup';
        $resp_url = 'http://topup.newphone-function.trade/api/wepay/callback/topup';

        $pay_to_ref1 = $request->input('number');;
        $pay_to_amount = $request->input('cash');
        $pay_to_company = $request->input('network_code');

        $users = $request->input('users');
        $network = $request->input('network');

        $topup_log = new TopupLog();
        $topup_log->orderid = '000000000';
        $topup_log->branch_name = $users;
        $topup_log->network = $network;
        $topup_log->network_code = $pay_to_company;
        $topup_log->number = $pay_to_ref1;
        $topup_log->cash = $pay_to_amount;
        $topup_log->status = 1;

        $topup_log->save();

        $dest_ref = 'MTOPUP'.sprintf("%06d",$topup_log->id);


        $client = new Client();
        try {
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

            $data = json_decode($response->getBody());

            if($data->code == '00000'){
                $topup_log->orderid = $data->transaction_id;
                $topup_log->dest_ref = $dest_ref;
                $topup_log->save();

            }else{
                $topup_log->delete();
            }
            return $data;


        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $data = json_decode($e->getResponse()->getBody(true));
            return Response::json($data);
            //return json_decode($e->getResponse()->getBody(true));
        }
    }

    public function refund(Request $request)
    {
        $username = env("WEPAY_USERNAME");
        $password = env("WEPAY_PASSWORD");
        $resp_url = 'http://topup.newphone-function.trade/api/wepay/callback/refund';
        $dest_ref = 'RMTOPUP';
        $pay_to_company = $request->input('network_code');
        $transaction_id = $request->input('transaction_id');


        $client = new Client();
        try {
            $response = $client->request('POST', 'https://www.wepay.in.th/mtopup_refund_api.php', [
                'form_params' => [
                    'username' => $username,
                    'password' => $password,
                    'transaction_id' => $transaction_id,
                    'resp_url' => $resp_url,
                    'dest_ref' => $dest_ref,
                    'pay_to_company' => $pay_to_company,
                ]
            ]);

            $data = $response->getBody();
            $a_data = explode("|", $data);

            if($a_data[0] == 'SUCCEED'){
                $topup_log = TopupLog::where('orderid','=',$transaction_id);
                if($topup_log->exists()){
                    $topup_log = $topup_log->first();
                    $topup_log->status = 5;
                    $topup_log->save();
                }
            }
            return $data;


        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $data = $e->getResponse()->getBody(true);
            return $data;
            //return json_decode($e->getResponse()->getBody(true));
        }
    }

    public function callbackTopup(Request $request)
    {
        $dest_ref = $request->input('dest_ref');
        $transaction_id = $request->input('transaction_id');
        $sms = $request->input('sms');
        $status = $request->input('status');
        $operator_trxnsid = $request->input('operator_trxnsid');

        $topup_log = TopupLog::where('orderid','=',$transaction_id);
        if($topup_log->exists()){
            $topup_log = $topup_log->first();
            $topup_log->status = $status;
            $topup_log->sms = $sms;
            $topup_log->operator_trxnsid = $operator_trxnsid;
            $topup_log->save();

            return 'SUCCEED';
        }else{
            return 'ERROR';
        }
    }

    public function callbackRefund(Request $request)
    {
        $dest_ref = $request->input('dest_ref');
        $transaction_id = $request->input('transaction_id');
        $refund_id = $request->input('refund_id');
        $drawn_amount = $request->input('drawn_amount');

        $topup_log = TopupLog::where('orderid','=',$transaction_id);
        if($topup_log->exists()){
            $topup_log = $topup_log->first();
            $topup_log->status = 6;
            $topup_log->drawn_amount = $drawn_amount;
            $topup_log->save();

            return 'SUCCEED';
        }else{
            return 'ERROR';
        }
    }


}

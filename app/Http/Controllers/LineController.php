<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LineController extends Controller
{
    protected $token = 'KJXYawTDuUVFGkrIGwGKma8E6KfkgEx0riyAA3spGm3';
    public function notifyReportToday()
    {


        $headers = [
            'Authorization' => 'Bearer ' . self::$token
        ];

        $client = new GuzzleHttp\Client();
        $response = $client->request('POST', 'https://notify-api.line.me/api/notify', [
            'form_params' => [
                'message' => 'ทดสอบ อิอิ'
            ],
            'headers' => $headers
        ]);
        //$xml=new SimpleXMLElement($response->getBody()->getContents());
        //echo $response;
    }


    public function getTodayReport()
    {
        $start = (new Carbon('now'))->hour(0)->minute(0)->second(0);
        $end = (new Carbon('now'))->hour(23)->minute(59)->second(59);
        $reports = TopupLog::whereBetween('created_at', [$start , $end])->where('status','=','1')->groupBy('branch_name','network')->
        selectRaw('sum(cash) as sum, branch_name,network')->get();

        return $reports;
    }

    public function getTodayReportTotal()
    {
        $start = (new Carbon('now'))->hour(0)->minute(0)->second(0);
        $end = (new Carbon('now'))->hour(23)->minute(59)->second(59);
        $report_totals = TopupLog::whereBetween('created_at', [$start , $end])->where('status','=','1')->groupBy('branch_name')->
        selectRaw('sum(cash) as sum, branch_name')->get();

        return $report_totals;
    }
}

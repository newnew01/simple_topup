<?php

namespace App\Http\Controllers;

use App\TopupLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class LineController extends Controller
{
    /*
    public function notifyReportToday()
    {
        $token = 'KJXYawTDuUVFGkrIGwGKma8E6KfkgEx0riyAA3spGm3';
        $datetime = Carbon::now()->format('d/m/Y H:i:s');

        $message = "\n";
        $message .= "วันที่: ".$datetime." \n\n";

        $todayReport = $this->getTodayReport();
        $todayReportTotal = $this->getTodayReportTotal();

        $message .= "[ยอดรวมทั้งหมด]\n";

        foreach ($todayReportTotal as $reportTotal){
            $message .= $reportTotal->branch_name.': '.$reportTotal->sum."\n";
        }

        $message .= "\n[แยกตามเครือข่าย]\n";

        $branch_name = '';
        foreach ($todayReport as $report){
            if($report->branch_name != $branch_name){
                $branch_name = $report->branch_name;
                $message .= $branch_name."\n";
            }
            $message .= '    '.$report->network.': '.$report->sum."\n";
        }



        $this->notify($token,$message);
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


    public function notify($token, $message)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $token
        ];

        $client = new Client();
        $response = $client->request('POST', 'https://notify-api.line.me/api/notify', [
            'form_params' => [
                'message' => $message
            ],
            'headers' => $headers
        ]);

        return $response;
    }
    */
}

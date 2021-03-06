<?php

namespace App\Http\Controllers;

use App\TopupLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class LogController extends Controller
{
    public function newLog(Request $request)
    {
        $orderid = $request->input('orderid');
        $branch_name = $request->input('branch_name');
        $network = $request->input('network');
        $number = $request->input('number');
        $cash = $request->input('cash');
        $status = 1;

        $log = new TopupLog();
        $log->orderid = $orderid;
        $log->branch_name = $branch_name;
        $log->network = $network;
        $log->number = $number;
        $log->cash = $cash;
        $log->status = $status;

        $log->save();

        return 'success';

    }

    public function updateLogStatus(Request $request)
    {
        $orderid = $request->input('orderid');
        $status = $request->input('status');

        $log = TopupLog::where('orderid','=',$orderid);

        if($log->exists()){
            $log = $log->first();
            $log->status = $status;
            $log->save();

            return 'success';

        }else{
            return 'error';
        }
    }

    public function getTodayLog()
    {
        $start = (new Carbon('now'))->hour(0)->minute(0)->second(0);
        $end = (new Carbon('now'))->hour(23)->minute(59)->second(59);

        $logs = TopupLog::whereBetween('created_at', [$start , $end])->latest()->get();

        return $logs;
    }

    public function getTodayReport()
    {
        $start = (new Carbon('now'))->hour(0)->minute(0)->second(0);
        $end = (new Carbon('now'))->hour(23)->minute(59)->second(59);
        $reports = TopupLog::whereBetween('created_at', [$start , $end])->where('status','=','2')->groupBy('branch_name','network')->
        selectRaw('sum(cash) as sum, branch_name,network')->get();

        return $reports;
    }

    public function getTodayReportTotal()
    {
        $start = (new Carbon('now'))->hour(0)->minute(0)->second(0);
        $end = (new Carbon('now'))->hour(23)->minute(59)->second(59);
        $report_totals = TopupLog::whereBetween('created_at', [$start , $end])->where('status','=','2')->groupBy('branch_name')->
        selectRaw('sum(cash) as sum, branch_name')->get();

        return $report_totals;
    }

    public function getMonthlyReport()
    {
        $monthStart = (new Carbon('now'))->startOfMonth();
        $monthEnd = (new Carbon('now'))->endOfMonth();
        $reports = TopupLog::whereBetween('created_at', [$monthStart , $monthEnd])->where('status','=','2')->groupBy('branch_name','network')->
        selectRaw('sum(cash) as sum, branch_name,network')->get();

        return $reports;
    }

    public function getMonthlyReportTotal()
    {
        //$now = Carbon::now();
        $monthStart = (new Carbon('now'))->startOfMonth();
        $monthEnd = (new Carbon('now'))->endOfMonth();

        $report_totals = TopupLog::whereBetween('created_at', [$monthStart , $monthEnd])->where('status','=','2')->groupBy('branch_name')->
        selectRaw('sum(cash) as sum, branch_name')->get();

        return $report_totals;
    }


    public function getEntireReportTotal()
    {

        $report_totals = TopupLog::where('status','=','2')->groupBy('branch_name')->
        selectRaw('sum(cash) as sum, branch_name')->get();

        return $report_totals;
    }

    public function getEntireReport()
    {
        $reports = TopupLog::where('status','=','2')->groupBy('branch_name','network')->
        selectRaw('sum(cash) as sum, branch_name,network')->get();

        return $reports;
    }
}

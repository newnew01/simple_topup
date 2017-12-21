<?php

namespace App\Http\Controllers;

use App\TopupLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        $logs = TopupLog::whereBetween('created_at', [$start , $end])->get();

        return $logs;
    }
}

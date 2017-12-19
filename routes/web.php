<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\User;
use Carbon\Carbon;

Route::get('/topup/{token}', function ($token) {
    $shiftHour = 7;
    $token_data = base64_decode($token);
    if(substr( $token_data, 0, 4 ) === "aBcD"){
        $token_data = substr( $token_data, 4, strlen($token_data) );
        $splitData = explode('@', $token_data, 2);
        $date_time = Carbon::now()->addHour($shiftHour);
        $date_time_access = Carbon::createFromFormat('dmYhi', $splitData[0]);
        if($date_time_access->addMinute(10) > $date_time){
            //echo 'OK'.$date_time_access.'|'.$date_time;

            $user = User::where('name','=',$splitData[1]);
            if($user->exists()){
                $user = $user->first();
                return view('topup')->with(compact('user'));
            }else{
                echo 'ACCESS DENIED : UNAUTHORIZED';
            }
        }else{
            //echo 'NOT OK'.$date_time_access.'|'.$date_time;
            echo 'ACCESS DENIED : TIMEOUT';
        }
    }else{
        echo 'ACCESS DENIED : INVALID TOKEN STRING';
    }





    //dd($splitData[0].' '.$splitData[1]);
    //Carbon::now()->format(dmYhi);
    //return view('topup');
});

Route::get('/time', function () {

    dd();

});
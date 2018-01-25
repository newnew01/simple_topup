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
use Illuminate\Support\Facades\Auth;

Route::get('/login/{token}', function ($token) {
    $shiftHour = 0;
    $token_data = base64_decode($token);
    if(substr( $token_data, 0, 4 ) === "aBcD"){
        $token_data = substr( $token_data, 4, strlen($token_data) );
        $splitData = explode('@', $token_data, 2);
        $date_time = Carbon::now()->addHour($shiftHour);
        $date_time_access = Carbon::createFromFormat('dmYHi', $splitData[0]);
        if($date_time_access->addMinute(5) > $date_time){
            //echo 'OK'.$date_time_access.'|'.$date_time;

            $user = User::where('name','=',$splitData[1]);
            if($user->exists()){
                $user = $user->first();
                $user->api_token = str_random(60);
                $user->save();
                Auth::login($user);
                return redirect('/');
            }else{
                return redirect('/err/1');
            }
        }else{
            //echo 'NOT OK'.$date_time_access.'|'.$date_time;
            return redirect('/err/2');
        }
    }else{
        return redirect('/err/3');
    }





    //dd($splitData[0].' '.$splitData[1]);
    //Carbon::now()->format(dmYhi);
    //return view('topup');
});

Route::get('/logout', function (){
    Auth::logout();
    return 'ออกจากระบบแล้ว';
});
Route::get('/err/{id}', 'ErrorController@showError');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        //$user = User::find(1);
        return view('topup');

    });
});


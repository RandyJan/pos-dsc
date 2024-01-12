<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use function App\Providers\isAuthenticated;

class LoginController extends Controller
{
    public function LoginJson(Request $request){

        $number = $request->input('uname');
        $pw = $request->input('psw');
        // $request->authenticate();
        //
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://172.16.12.234:8087/api/login',[
            "number"=>$number,
            "password"=>$pw
        ]);
      //  Log::info($response);
        if($response['statusCode'] == 0){
        //Log::info($response);
        // return response()->noContent();
       // $request->session()->regenerate();
       return back()->withErrors([
        'username'=>"Login Failed please enter appropriate credentials for this station"
       ]);
    }
    $minutes = 1440;
    $responseArray = $response->json();
     Cache::put('Cashier_data',$responseArray, $minutes);
     Cache::put('Auth','1',$minutes);
    // $test = Cache::get('Cashier_data');
    // $test2 = json_encode($test);
    // Log::info($test2);
    return redirect()->intended(RouteServiceProvider::HOME);

    }
    public function LogoutJson(Request $request){
        $minutes = 1140;
        Cache::put('Auth','0',$minutes);

        return view('LoginNew');


    }
}

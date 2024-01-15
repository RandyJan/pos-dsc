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
        $serialNumber = trim(shell_exec("wmic diskdrive get serialnumber 2>&1"));
        $iptest = trim(shell_exec("ipconfig"));
        $availableWifi = shell_exec("netsh wlan show networks mode=Bssid");

        $serialNumber = str_replace("SerialNumber", "", $serialNumber);
        Log::info($availableWifi);
        Log::info($serialNumber);
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
    // $minutes = 1440;
    $responseArray = $response->json();
     Cache::put('Cashier_data',$responseArray);
     Cache::put('Auth','1');
    // $test = Cache::get('Cashier_data');
    // $test2 = json_encode($test);
    // Log::info($test2);
    return redirect()->intended(RouteServiceProvider::HOME);

    }
    public function LogoutJson(Request $request){
        // $minutes = 1140;
        $serialNumber = trim(shell_exec("wmic diskdrive get serialnumber 2>&1"));
        $serialNumber = str_replace("SerialNumber", "", $serialNumber);
        Cache::put('Auth','0');

        return view('LoginNew');


    }
}

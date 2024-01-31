<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Illuminate\Support\Facades\Log;
class mopController extends Controller
{
    public function mop(){
        $mopresponse = Http::withHeaders([
            'Content-Type'=>'application/json',
        ])->get('http://172.16.12.178:88/api/finalisations');
        // LOG::info($mopresponse);
        $mop = $mopresponse['data'];
        return view('pos')->with('mopData', $mop);

    }
}

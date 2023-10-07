<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Illuminate\Support\Facades\Log;
class mopController extends Controller
{
    public function mop(Request $request){
        $mopresponse = Http::withHeaders([
            'Content-Type'=>'application/json',
        ])->get('http://venus-api.test:88/api/finalisations');
        LOG::info($mopresponse);
        foreach($mopresponse['data'] as $mop){
        $mopData = $mop->name;
        return view('pos')->with('mopData', $mopData);
        }
    }
}

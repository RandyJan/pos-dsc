<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class receiptController extends Controller
{
  public function getReceiptLayout(Request $request){
    $response = Http::withHeaders([
        "ContentType"=> "json/application"
    ])->post('http://172.16.12.234:8088/api/receipt-sample',([
        'posID'=>1,
        'transaction_no'=>$request->transNo

    ]));
    // $finalLayout = $layout->data;
    $layout = json_decode($response->body(), true);
    Log::info($layout);
    return view('transaction')
    ->with('receipt',$layout);
  }
}

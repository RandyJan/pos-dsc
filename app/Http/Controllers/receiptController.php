<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\receiptItems;

class receiptController extends Controller
{

  public function getReceiptLayout(Request $request){
    $check = Cache::get('Auth');
    if($check == 0 ){
        return view('LoginNew');
    }
    $response = Http::withHeaders([
        "ContentType"=> "json/application"
    ])->post('http://172.16.12.90:8087/api/receipt-sample',([
        'posID'=>1,
        'transaction_no'=>$request->transNo

    ]));
    $transactionData = receiptItems::where('Transaction_ID', $request->transactionNumber)->get();
    Log::info($request->all());
    // $finalLayout = $layout->data;
    $layout = json_decode($response->body(), true);
    // Log::info($request->transNo);
    return view('transaction')
    ->with('receipt',$layout);
  }
}

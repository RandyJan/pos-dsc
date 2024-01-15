<?php

namespace App\Http\Controllers;

use stdClass;
use GuzzleHttp\Client;
use App\Models\transaction;
use App\Models\transactionBIR;
use App\Models\receiptItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class pumpController extends Controller
{
    public function pump(Request $request)
    {
        $check = Cache::get('Auth');
        if($check == 0 || !Cache::has('Auth')){
            return view('LoginNew');
        }
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode('admin:admin')
        ])->post('http://172.16.12.200/jsonPTS', [
            'Protocol' => 'jsonPTS',
            'Packets' => [
                [
                    'Id' => 1,
                    'Type' => 'PumpGetStatus',
                    'Data' => [
                        'Pump' => 1
                    ]
                ],
                [
                    'Id' => 2,
                    'Type' => 'PumpGetStatus',
                    'Data' => [
                        'Pump' => 2
                    ]
                ],
                [
                    'Id' => 3,
                    'Type' => 'PumpGetStatus',
                    'Data' => [
                        'Pump' => 3
                    ]
                ],
                [
                    'Id' => 4,
                    'Type' => 'PumpGetStatus',
                    'Data' => [
                        'Pump' => 4
                    ]
                ]
            ]
        ]);

        $data = $response->json();
        $packets = $data['Packets'];
        $pendingTransactionsByPump = [];
        // LOG::info($packets);
        foreach ($packets as $packet) {
            if ($packet['Type'] === 'PumpEndOfTransactionStatus') {
                // Log::info("EOTTTT");
                $transaction = new Transaction();
                $transaction->pumpid = $packet['Data']['Pump'];
                $transaction->pump = $packet['Data']['Pump'];
                if ($packet['Data']['Nozzle'] === 1) {
                    $transaction->nozzle = 'Premium';
                } elseif ($packet['Data']['Nozzle'] === 2) {
                    $transaction->nozzle = 'Diesel';
                } else {
                    $transaction->nozzle = 'Regular';
                }

                $transaction->volume = $packet['Data']['Volume'];
                // $transaction->tcvolume = $packet['Data']['TCVolume'];
                $transaction->price = $packet['Data']['Price'];
                $transaction->amount = $packet['Data']['Amount'];
                $transaction->transaction = $packet['Data']['Transaction'];
                // $transaction->userid = $packet['Data']['User'];
                $transaction->state = 0;
                $transaction->status = 0;
                $existingrecord = transaction::where('transaction', $packet['Data']['Transaction'])->where('pumpid', $packet['Data']['Pump'])
                    ->where('volume', $packet['Data']['Volume'])->get();
                if (empty($existingrecord->count())) {
                    $transaction->save();
                } else {
                    // LOG::info($existingrecord);
                }

                $pumpId = $packet['Data']['Pump'];
                if (!isset($pendingTransactionsByPump[$pumpId])) {
                    $pendingTransactionsByPump[$pumpId] = [];
                }
                $pendingTransactionsByPump[$pumpId][] = $transaction;
            }
        }

        // $pendingtrans = transaction::where('state', 0)->get();
        // Fetch all pending transactions from the database
        $pendingTransactions = Transaction::where('state',0)->get();
        // $transaction = Transaction::all();
        // Group pending transactions by pump id
        $pendingTransactionsByPump = [];
        foreach ($pendingTransactions as $transaction) {
            $pumpId = $transaction->pumpid;
            if (!isset($pendingTransactionsByPump[$pumpId])) {
                $pendingTransactionsByPump[$pumpId] = [];
            }
            $pendingTransactionsByPump[$pumpId][] = $transaction;
        }
        // LOG::info($transaction);

        // dd($pendingtrans);
        //     $mopresponse = Http::withHeaders([
        //         'Content-Type'=>'application/json',
        //     ])->get('http://172.16.12.178:88/api/finalisations');

        //    $mop = $mopresponse['data'];

        function getMopData()
        {
            $mopresponse = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->get('http://172.16.12.234:8087/api/finalisations');

            return $mopresponse['data'];
        }
        $testb = []; // Initialize an empty array to store the results

        foreach ($packets as $packetb) {
           $testing = $packetb['Data']['NozzleUp']??NULL;
            $dataToPass[] = [
                'Id' => $packetb['Id'],
                'Type' => $packetb['Type'],
                'Data' => [
                    'Nozzle' =>  $packetb['Data']['Nozzle']?? NULL,
                    'Volume' => $packetb['Data']['Volume']?? NULL,
                    'Price' =>$packetb['Data']['Price']?? NULL,
                    'Amount' => $packetb['Data']['Amount']?? NULL,
                    'Pump' => $packetb['Data']['Pump']?? NULL,
                    'NozzleUp' => $testing == NULL ? 0:($packetb['Data']['NozzleUp'] == '1' ? 'PRM' : ($packetb['Data']['NozzleUp'] == '2' ? 'DSL' : ($packetb['Data']['NozzleUp'] == '3' ? 'UNL' : NULL))),
                    // "test"=> $packetb['Data']['NozzleUp']??NULL,
                    'Request' => $packetb['Data']['Request']?? NULL,
                    'LastNozzle' => $packetb['Data']['LastNozzle']?? NULL,
                    'LastVolume' => $packetb['Data']['LastVolume']?? NULL,
                    'LastPrice' => $packetb['Data']['LastPrice']?? NULL,
                    'LastAmount' => $packetb['Data']['LastAmount']?? NULL,
                    'LastTransaction' => $packetb['Data']['LastTransaction']?? NULL,
                    'User' => $packetb['Data']['User']?? NULL,
                ],
            ];
        }

         //Log::info($dataToPass);
        $mop = Cache::remember('mop_data', 60, function () {
            return getMopData();
        });
        $cashierData = Cache::get('Cashier_data');

        // Log::info($testb);
        // Log::info($testb);
        return view('pos')
            ->with('datab', $dataToPass)
            // ->with('transaction', $transaction)
            ->with('pending', $pendingTransactions)
            ->with('pendingTransactionsByPump', $pendingTransactionsByPump)
            ->with('mopData', $mop)
            ->with('cashier',$cashierData);



        // LOG::info($mop);


    }

    public function authorizejson(Request $request)
    {
        $check = Cache::get('Auth');
        if($check == 0 ){
            return view('LoginNew');
        }
        $pumpid = $request->input('id');
        $price = $request->input('price');
        $nozzle = $request->input('nozzle');
        $amount = $request->input('amount');
        $nozzleb = $nozzle == 'PRM'?'1':($nozzle == 'DSL'?'2':($nozzle == '3' ? 'UNL':0)) ;
        Log::info($nozzleb);
        // LOG::info($nozzle);
        $cookie = request()->cookie();
        // $cookie2 = cookie::get();
        // Log::info($request->all());
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode('admin:admin')
        ])->post('http://172.16.12.200/jsonPTS', [
            'Protocol' => 'jsonPTS',
            'Packets' => [
                [
                    'Id' => $pumpid,
                    'Type' => 'PumpAuthorize',
                    'Data' => [
                        'Pump' => $pumpid,
                        'Nozzle' => $nozzleb,
                        'Type' => 'FullTank',
                        'Price' => $price
                    ]

                ]
            ]
        ]);
       LOG::info($response);

        return response()->noContent();
    }
    public function pumpstop(Request $request)
    {
        $check = Cache::get('Auth');
        if($check == 0 ){
            return view('LoginNew');
        }
        $pumpid =  $request->input('pumpid');
        Log::info($request->all());
        Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode('admin:admin')
        ])->post('http://172.16.12.200/jsonPTS', [
            'Protocol' => 'jsonPTS',
            'Packets' => [
                [
                    'Id' => $pumpid,
                    'Type' => 'PumpStop',
                    'Data' => [
                        'Pump' => $pumpid,

                    ]

                ]
            ]
        ]);
        return response()->noContent();
    }

    public function payTransaction(Request $request)
    {
        $check = Cache::get('Auth');
        if($check == 0 ){
            return view('LoginNew');
        }
        $transactionId = $request->transactionId;
        // Find the transaction and set status to 1
        $transaction = Transaction::find($transactionId);
        //Log::info($transactionId);


        $transactionb = [
            'id'=> $transaction->id,
            'pumpid'=> $transaction->pumpid,
            'pump'=> $transaction->pump,
            'transaction'=> $transaction->transaction,
            'state'=> $transaction->state,
            'nozzle'=> $transaction->nozzle,
            'amount' => str_replace(['.', ','], '', number_format($transaction->amount)),
            'volume'=>str_replace(['.', ','], '', number_format($transaction->volume)),
            'price'=> $transaction->price,
            'tcvolume'=> $transaction->tcvolume,
            'totalamount'=> $transaction->totalamount,
            'totalvolume'=> $transaction->totalvolume,
            'userid'=> $transaction->userid,
            'status'=> $transaction->status,
            'is_voided'=> $transaction->is_voided,
        ];
        if ($transaction) {
            // $transaction->status = 1;
            // $transaction->save();
            // var_dump($transaction);
            Transaction::where('id',$transactionId)->update([
                'state'=>1,
            ]);
            return $transactionb;
        }

        return response('Transaction not found', 404);
    }

    public function voidTransaction(Request $request)
    {
        $check = Cache::get('Auth');
        if($check == 0 ){
            return view('LoginNew');
        }
        $transactionId = $request->transactionId;
        // Log::info('Received transactionId: ' . $transactionId);

        // Attempt to find the transaction by ID
      // log::info($transactionId);
        $transaction = Transaction::where('transaction', $transactionId)->first();
        Transaction::where('transaction',$transactionId)->update([
            'state' => 0,
            'is_voided'=> 1]);
        if ($transaction) {
            // Log::info('Found transaction: ' . $transaction->transaction);
            // Log::info('Current Status: ' . $transaction->status);

            $transaction->status = 0;
            $transaction->save();
            // Log::info('Updated Status: ' . $transaction->status);

            return response('Transaction voided', 200);
        } else {
            // Log::error('Failed to void transaction. Transaction not found.');
            return response('Failed to void transaction. Transaction not found.', 404);
        }
    }

    public function voidAllTransactions(Request $request)
    {
        $check = Cache::get('Auth');
        if($check == 0 ){
            return view('LoginNew');
        }
        // Get all transactions and update their statuses to 0 (voided)
        $transactions = Transaction::all();
        foreach ($transactions as $transaction) {
            $transaction->status = 0;
            $transaction->save();
        }

        return response('All transactions voided', 200);
    }
    public function sendTransaction(Request $request){
        $check = Cache::get('Auth');
        if($check == 0 || !Cache::has('Auth') ){
            return view('LoginNew');
        }

        $data = $request['data'];
        // $datab = json_decode($data, true);
        // $formattedData = http_build_query($data);
        // parse_str($formattedData, $dataArray);
        // Log::info($data);
        $maxtransid = transactionBIR::max('Transaction_Number');
        $nexttransid = $maxtransid + 1;
        $responseb = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://172.16.12.234:8087/api/addnewTransaction',[
    'transNo'=>$nexttransid,
    'cashierID' => $data['cashierID'],
  'subAccID' => '',
  'accountID' => '',
  'posID' => $data['posID'],
  'taxTotal' => $data['taxTotal'],
  'saleTotal' => $data['saleTotal'],
  'isManual' => $data['isManual'],
  'isZeroRated' => $data['isZeroRated'],
  'customerName' => 'RandyJan',
  'address' => 'Camella Annex',
  'TIN' => '1234',
  'businessStyle' => '12331',
  'cardNumber' => '232',
  'approvalCode' => '2',
  'bankCode' => '321',
  'type' => '1',
  'isRefund' => $data['isRefund'],
  'transaction_type' => $data['transaction_type'],
  'isRefundOrigTransNum' => '',
  'transaction_resetter' => '',
  'birReceiptType' => '',
  'poNum' => '',
  'plateNum' =>'',
  'odometer' => '',
  'transRefund' => $data['transRefund'],
  'grossRefund' => $data['grossRefund'],
  'subAccPmt' => '',
  'vehicleTypeID' => $data['vehicleTypeID'],
  'isNormalTrans' => $data['isNormalTrans'],
  'items' => $data['items']
]);
 Cache::put('transNo',$nexttransid);
 $transNo = Cache::get('transNo');
 Log::info($transNo);
$response = Http::withHeaders([
    "ContentType"=> "json/application"
])->post('http://172.16.12.234:8087/api/receipt-sample',([
    'posID'=>1,
    'transaction_no'=>$nexttransid

]));
// $finalLayout = $layout->data;
$layout = json_decode($response->body(), true);
// Log::info($request->transNo);

$transItems = Http::withHeaders([
    "ContentType"=> "json/application"
])->post('http://172.16.12.234:8087/api/getItems',([
    'posID'=>1,
    'trans_ID'=>$transNo,

]));
// $id = 577488;
// receiptItems::ActiveTransaction($id);
//$activetrans = new receiptItems;
// $test = $activetrans->ActiveTransaction($response);
// $test=577485;
// $itemsData = receiptItems::ActiveTransaction($test);
// Log::info($itemsData);
// $decodedTransItems = json_decode($transItems);
return response($responseb);




        //LOG::info($response);
        // return response($response);


    }
public function updateTransaction(Request $request){
        // $transaction = Json_decode($request->transaction);
        $check = Cache::get('Auth');
        if($check == 0 ){
            return view('LoginNew');
        }
    $response = transaction::where('transaction',$request->transaction)->update([
        'state'=>2
    ]);
    // Log::info();
    return redirect('/pos');

}


}

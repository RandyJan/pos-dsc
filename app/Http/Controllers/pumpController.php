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

                $transaction = new Transaction();
                $transaction->pumpid = $packet['Data']['Pump'];
                $transaction->pump = $packet['Data']['Pump'];
                if ($packet['Data']['Nozzle'] === 1) {
                    $transaction->nozzle = 'PREMIUM';
                } elseif ($packet['Data']['Nozzle'] === 2) {
                    $transaction->nozzle = 'DIESEL';
                } else {
                    $transaction->nozzle = 'REGULAR';
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

        function getMopData()
        {
            $mopresponse = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->get('http://172.16.12.90:8087/api/finalisations');

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


        $mop = Cache::remember('mop_data', 60, function () {
            return getMopData();
        });
        $cashierData = Cache::get('Cashier_data');
        // log::info($mop);

        return view('pos')
            ->with('datab', $dataToPass)
            // ->with('transaction', $transaction)
            ->with('pending', $pendingTransactions)
            ->with('pendingTransactionsByPump', $pendingTransactionsByPump)
            ->with('mopData', $mop)
            ->with('cashier',$cashierData);
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
        $cookie = request()->cookie();
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

        return response()->noContent();
    }
    public function pumpstop(Request $request)
    {
        $check = Cache::get('Auth');
        if($check == 0 ){
            return view('LoginNew');
        }
        $pumpid =  $request->input('pumpid');
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
        $transaction = Transaction::find($transactionId);


        $transactionb = [
            'id'=> $transaction->id,
            'pumpid'=> $transaction->pumpid,
            'pump'=> $transaction->pump,
            'transaction'=> $transaction->transaction,
            'state'=> $transaction->state,
            'nozzle'=> $transaction->nozzle,
            'amount' => str_replace(',', '', number_format($transaction->amount, 2)),
            'volume' => str_replace(',', '', number_format($transaction->volume, 2)),
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

        $transaction = Transaction::where('transaction', $transactionId)->first();
        Transaction::where('transaction',$transactionId)->update([
            'state' => 0,
            'is_voided'=> 1]);
        if ($transaction) {

            $transaction->status = 0;
            $transaction->save();

            return response('Transaction voided', 200);
        } else {
            return response('Failed to void transaction. Transaction not found.', 404);
        }
    }

    public function voidAllTransactions(Request $request)
    {
        $check = Cache::get('Auth');
        if($check == 0 ){
            return view('LoginNew');
        }
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
        // Log::info($data);
        $maxtransid = transactionBIR::max('Transaction_Number');
        $nexttransid = $maxtransid + 1;
        $responseb = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://172.16.12.90:8087/api/addnewTransaction',[

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
  'subAccAmt' => '',
  'vehicleTypeID' => $data['vehicleTypeID'],
  'isNormalTrans' => $data['isNormalTrans'],
  'items' => $data['items']
]);
$transID = $responseb['transID'];
Log::info($transID);
Cache::put('transNo',$transID);
 $transNo = Cache::get('transNo');
$response = Http::withHeaders([
    "ContentType"=> "json/application"
])->post('http://172.16.12.90:8087/api/receipt-sample',([
    'posID'=>1,
    'transaction_no'=>$transNo

]));
$layout = json_decode($response->body(), true);

$transItems = Http::withHeaders([
    "ContentType"=> "json/application"
])->post('http://172.16.12.90:8087/api/getItems',([
    'posID'=>1,
    'trans_ID'=>$transNo,

]));
// Log::info($responseb);
return response($responseb);
    }
public function updateTransaction(Request $request){
        $check = Cache::get('Auth');
        if($check == 0 ){
            return view('LoginNew');
        }
    $response = transaction::where('transaction',$request->transaction)->update([
        'state'=>2
    ]);
    return redirect('/pos');

}
    public function getReceiptItems(Request $request){
        $transNo = $request->data;
        $transItems = Http::withHeaders([
            'Content-Type' => 'application/json' // Fixed typo and header name
        ])->post('http://172.16.12.90:8087/api/receiptItems', [
            'transNumber' => $transNo,
        ]);

        $finaltrans = collect($transItems->json())->map(function ($item) {
            return [$item['Item_Description'],
            $item['Item_Quantity'],
            $item['Item_Price'],
            $item['Item_Value'],
            $item['Item_Type'],];
        })->toArray();
        return $finaltrans;

    }

}

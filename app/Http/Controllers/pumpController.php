<?php

namespace App\Http\Controllers;

use stdClass;
use GuzzleHttp\Client;
use App\Models\transaction;
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
        $pendingTransactions = Transaction::get();
        $transaction = Transaction::all();
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
        $mop = Cache::remember('mop_data', 60, function () {
            return getMopData();
        });

        return view('pos')
            ->with('datab', $packets)
            ->with('transaction', $transaction)
            ->with('pending', $pendingTransactions)
            ->with('pendingTransactionsByPump', $pendingTransactionsByPump)
            ->with('mopData', $mop);


        // LOG::info($mop);


    }

    public function authorizejson(Request $request)
    {
        $pumpid = $request->input('pumpid');
        $price = $request->input('price');
        $nozzle = $request->input('nozzle');
        $amount = $request->input('amount');
        // LOG::info($nozzle);
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
                        'Nozzle' => $nozzle,
                        'Type' => 'FullTank',
                        'Price' => $price
                    ]

                ]
            ]
        ]);
        // LOG::info($response);

        return redirect()->route('pos');
    }
    public function pumpstop(Request $request)
    {
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
        return redirect()->route('pos');
    }

    public function payTransaction(Request $request)
    {
        $transactionId = $request->input('transactionId');
        // Find the transaction and set status to 1
        $transaction = Transaction::find($transactionId);
        if ($transaction) {
            $transaction->status = 1;
            $transaction->save();
            return $transaction;
        }
        return response('Transaction not found', 404);
    }

    public function voidTransaction(Request $request)
    {
        $transactionId = $request->input('transactionId');
        // Log::info('Received transactionId: ' . $transactionId);

        // Attempt to find the transaction by ID
        $transaction = Transaction::where('transaction', $transactionId)->first();

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
        // Get all transactions and update their statuses to 0 (voided)
        $transactions = Transaction::all();
        foreach ($transactions as $transaction) {
            $transaction->status = 0;
            $transaction->save();
        }

        return response('All transactions voided', 200);
    }
    public function sendTransaction(Request $request){

        $data = $request['data'];
        // $datab = json_decode($data, true);
        // $formattedData = http_build_query($data);
        // parse_str($formattedData, $dataArray);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://172.16.12.234:8087/api/addnewTransaction',[
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

$response = Http::withHeaders([
    "ContentType"=> "json/application"
])->post('http://172.16.12.234:8087/api/receipt-sample',([
    'posID'=>1,
    'transaction_no'=>$request->transNo

]));
// $finalLayout = $layout->data;
$layout = json_decode($response->body(), true);
Log::info($request->transNo);

$transItems = Http::withHeaders([
    "ContentType"=> "json/application"
])->post('http://172.16.12.234:8087/api/getItems',([
    'posID'=>1,
    'trans_ID'=>$response

]));
// $id = 577488;
// receiptItems::ActiveTransaction($id);
//$activetrans = new receiptItems;
// $test = $activetrans->ActiveTransaction($response);
// $test=577485;
// $itemsData = receiptItems::ActiveTransaction($test);
// Log::info($itemsData);
// $decodedTransItems = json_decode($transItems);
return view('transaction')
->with('receipt',$layout);





        //LOG::info($response);
        // return response($response);


    }


}

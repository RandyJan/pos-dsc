<?php

namespace App\Http\Controllers;

use stdClass;
use GuzzleHttp\Client;
use App\Models\transaction;
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
                    LOG::info($existingrecord);
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

        // Group pending transactions by pump id
        $pendingTransactionsByPump = [];
        foreach ($pendingTransactions as $transaction) {
            $pumpId = $transaction->pumpid;
            if (!isset($pendingTransactionsByPump[$pumpId])) {
                $pendingTransactionsByPump[$pumpId] = [];
            }
            $pendingTransactionsByPump[$pumpId][] = $transaction;
        }
        // LOG::info($pendingtrans);

        // dd($pendingtrans);
        //     $mopresponse = Http::withHeaders([
        //         'Content-Type'=>'application/json',
        //     ])->get('http://172.16.12.178:88/api/finalisations');

        //    $mop = $mopresponse['data'];
        function getMopData()
        {
            $mopresponse = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->get('http://172.16.12.128:88/api/finalisations');

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
        LOG::info($nozzle);
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
    public function getItems(Request $request){

        $data = $request['objectArray'];

        $formattedData = http_build_query($data);
        parse_str($formattedData, $dataArray);
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->post('http://97.74.86.26:8083/TransactionCtrl/addNewTransaction',[
    'cashierID' => 1,
  'subAccID' => '',
  'accountID' => '',
  'posID' => '1',
  'taxTotal' => '0',
  'saleTotal' => '0',
  'isManual' => '0',
  'isZeroRated' => '0',
  'customerName' => '',
  'address' => '',
  'TIN' => '',
  'businessStyle' => '',
  'cardNumber' => '',
  'approvalCode' => '',
  'bankCode' => '',
  'type' => '',
  'isRefund' => '0',
  'transaction_type' => '1',
  'isRefundOrigTransNum' => '',
  'transaction_resetter' => '',
  'birReceiptType' => '',
  'poNum' => '',
  'plateNum' =>'',
  'odometer' => '',
  'transRefund' => '0',
  'grossRefund' => '0',
  'subAccPmt' => '',
  'vehicleTypeID' => '6',
  'isNormalTrans' => '1',
  'items' =>[
    [
      'itemNumber' => '1',
      'itemType' => '2',
      'itemDesc' => 'Premium',
      'itemPrice' => '50.0',
      'itemQTY' => '2.8300000000000001',
      'itemValue' => '141.5',
      'itemID' => '25390',
      'itemTaxAmount' => '32.625',
      'deliveryID' => '1',
      'itemTaxId' => '1',
      'gcNumber' => '',
      'gcAmount' => '',
      'originalItemValuePreTaxChange' => '271.875',
      'isTaxExemptItem' => '',
      'isZeroRatedTaxItem' => '',
      'itemDiscTotal' => '',
      'departmentID' => '',
      'itemDiscCodeType' => '',
      'itemDBPrice' => '50.0',
    ],
 [
      'itemNumber' => '2',
      'itemType' => '2',
      'itemDesc' => 'Premium',
      'itemPrice' => '50.0',
      'itemQTY' => '3.2599999999999998',
      'itemValue' => '163.0',
      'itemID' => '25389',
      'itemTaxAmount' => '32.625',
      'deliveryID' => '1',
      'itemTaxId' => '1',
      'gcNumber' => '',
      'gcAmount' => '',
      'originalItemValuePreTaxChange' => '271.875',
      'isTaxExemptItem' => '',
      'isZeroRatedTaxItem' => '',
      'itemDiscTotal' => '',
      'departmentID' => '',
      'itemDiscCodeType' => '',
      'itemDBPrice' => '50.0',
    ],
    [
      'itemNumber' => '3',
      'itemType' => '2',
      'itemDesc' => 'CASH',
      'itemPrice' => '304.5',
      'itemQTY' => '1',
      'itemValue' => '500',
      'itemID' => '1',
      'itemTaxAmount' => '0',
      'deliveryID' => '1',
      'itemTaxId' => '1',
      'gcNumber' => '',
      'gcAmount' => '',
      'originalItemValuePreTaxChange' => '0',
      'isTaxExemptItem' => '',
      'isZeroRatedTaxItem' => '',
      'itemDiscTotal' => '',
      'departmentID' => '',
      'itemDiscCodeType' => '',
      'itemDBPrice' => '0',
    ]
],
]);



        LOG::info($response);
        return response()->json($response);


    }


}

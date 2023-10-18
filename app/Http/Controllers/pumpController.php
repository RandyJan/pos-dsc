<?php

namespace App\Http\Controllers;

use App\Models\transaction;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
        $pendingTransactions = Transaction::where('state', 0)->get();

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
            ])->get('http://172.16.12.178:88/api/finalisations');

            return $mopresponse['data'];
        }
        $mop = Cache::remember('mop_data', 60, function () {
            return getMopData();
        });
        LOG::info($mop);
        return view('pos')->with('datab', $packets)
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
        try {
            // Retrieve the transaction ID from the request
            $transactionId = $request->input('transactionId');

            // Fetch the transaction details based on the transaction ID
            $transaction = Transaction::find($transactionId);

            if ($transaction) {

                return response()->json($transaction);
            } else {
                // Transaction not found
                return response()->json(['error' => 'Transaction not found'], 404);
            }
        } catch (\Exception $e) {
            // Handle exceptions here
            return response()->json(['error' => 'Failed to fetch transaction details'], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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
                ],  [
                    'Id' => 3,
                    'Type' => 'PumpGetStatus',
                    'Data' => [
                        'Pump' => 3
                    ]
                ],  [
                    'Id' => 4,
                    'Type' => 'PumpGetStatus',
                    'Data' => [
                        'Pump' => 4
                    ]
                ]
            ]
        ]);

        $data = $response->json();

        $pumpId = json_encode($data['Packets'], true);
        $finalpump = json_decode($pumpId, true);






        return view('pos')->with('datab', $finalpump);
    }
    public function authorizejson(Request $request){
        $pumpid = $request->input('pumpid');
        $price = $request->input('price');
        $volume = $request->input('volume');
        $amount = $request->input('amount');

         Http::withHeaders([
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
                        'Nozzle'=>1,
                        'Type'=>'FullTank',
                        'Price' =>$price
                    ]

            ]
            ]
        ]);


        return redirect()->route('pos');

    }
    public function pendingtrans(){

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
                ],  [
                    'Id' => 3,
                    'Type' => 'PumpGetStatus',
                    'Data' => [
                        'Pump' => 3
                    ]
                ],  [
                    'Id' => 4,
                    'Type' => 'PumpGetStatus',
                    'Data' => [
                        'Pump' => 4
                    ]
                ]
            ]
        ]);

        $pumptype = json_decode($response->body(), true);

        foreach($pumptype['Packets'] as $packet){
            if($packet['Type'] === 'PumpEndOfTransactionStatus'){

                $id = $packet['Id'];
                $type = $packet['Type'];
                $amount = $packet['Data']['Amount'];
                $price = $packet['Data']['Price'];
                $nozzle = $packet['Data']['Nozzle'];
                $transaction = $packet['Data']['Transaction'];
                $volume = $packet['Data']['Volume'];
                $user = $packet['Data']['User'];

                transaction::create([
                    'pumpid' => $id,
                    'pump' => $nozzle,
                    'transaction' => $transaction,
                    'state' => $type,
                    'nozzle' =>$nozzle,
                    'amount' => $amount,
                    'volume' =>$volume,
                    'price' => $price,
                    'tcvolume' =>'testvolume',
                    'totalamount'=>'testamount',
                    'totalvolume' => 'totalvolume',
                    'userid'=> $user
                ]);
            }
        }


    }
    public function pumpstop(Request $request){
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
}

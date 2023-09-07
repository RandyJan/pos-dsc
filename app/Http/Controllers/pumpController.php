<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
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
                    'Type' => 'GetPumpsConfiguration'
                ]
            ]
        ]);

        $data = $response->json();
        // $datab = $data->Packets;
        $pumpId = $data['Packets'][0]['Data']['Pumps'][0]['Id'];

        Log::info($pumpId);

        // return view('pos', ['datab' => $datab]);
    }
}

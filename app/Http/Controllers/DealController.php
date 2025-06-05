<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDealAccountRequest;
use Illuminate\Support\Facades\Http;

class DealController extends Controller
{
    public function store(CreateDealAccountRequest $request)
    {
        ['deal' => $deal, 'account' => $account] = $request->all();
        
        $response = Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . $request->user()->api_token->access_token,
            'Content-Type' => 'application/json',
        ])->post(auth()->user()->api_token->api_domain . '/crm/v5/Accounts', [
            'data' => [
                [
                    'Account_Name' => $account['name'],
                    'Phone' => $account['phone'],
                    'Website' => $account['website']
                ]
            ]
        ]);

        if($response->json()['data'][0]['status'] == 'error') {
            throw new \Exception($response->json()['data'][0]['message']);
        } 

        $response = Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . $request->user()->api_token->access_token,
            'Content-Type' => 'application/json',
        ])->post(auth()->user()->api_token->api_domain . '/crm/v5/Deals', [
            'data' => [
                [
                    'Deal_Name' => $deal['name'],
                    'Stage' => $deal['stage'],
                    'Account_Name' => $account['name'],
                    'Closing_Date' => $deal['closing_date']
                ]
            ]
        ]);

        if($response->json()['data'][0]['status'] == 'error') {
            throw new \Exception($response->json()['data'][0]['message']);
        } 

        return back(201);
    }
}

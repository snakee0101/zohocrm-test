<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDealAccountRequest;
use Illuminate\Support\Facades\Http;

class DealController extends Controller
{
    public function store(CreateDealAccountRequest $request)
    {
        ['deal' => $deal, 'account' => $account] = $request->all();
        
        $user = auth()->user();

        //refresh token if expired

        if(now()->greaterThanOrEqualTo(
            $user->api_token
                ->updated_at
                ->addSeconds($user->api_token->expires_in)
        )) {
            $refresh_token = $user->api_token->refresh_token;
            $client_id = '1000.7DBABT5NN8EJYMLJABQVIMHIUGHIGT';
            $client_secret = 'b04db67f267530f878abf27024659d73f5911422e7';

            $newTokenResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://accounts.zoho.eu/oauth/v2/token?refresh_token={$refresh_token}&client_id={$client_id}&client_secret={$client_secret}&grant_type=refresh_token");
            
            $user->api_token->update([
                'access_token' => $newTokenResponse->json()["access_token"]
            ]);
        }

        //create a deal and an account

        $response = Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . $user->api_token->access_token,
            'Content-Type' => 'application/json',
        ])->post($user->api_token->api_domain . '/crm/v5/Accounts', [
            'data' => [
                [
                    'Account_Name' => $account['name'],
                    'Phone' => $account['phone'],
                    'Website' => $account['website']
                ]
            ]
        ]);

        if($response->json()['data'][0]['status'] == 'error') {
            return response()->json([
                'error' => $response->json()['data'][0]['message'],
                'access_token' => $user->api_token->access_token
            ]);
        } 

        $response = Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . $user->api_token->access_token,
            'Content-Type' => 'application/json',
        ])->post($user->api_token->api_domain . '/crm/v5/Deals', [
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
            return response()->json([
                'error' => $response->json()['data'][0]['message'],
                'access_token' => $user->api_token->access_token
            ]);
        }

        return response(status: 201);
    }
}

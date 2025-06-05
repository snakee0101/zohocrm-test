<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DealController extends Controller
{
    public function store(Request $request)
    {
        ['deal' => $deal, 'account' => $account] = $request->all();

        Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . $request->user()->api_token->access_token,
            'Content-Type' => 'application/json',
        ])->post('https://www.zohoapis.eu/crm/v5/Accounts', [
            'data' => [
                [
                    'Account_Name' => $account['name'],
                    'Phone' => $account['phone'],
                    'Website' => $account['website']
                ]
            ]
        ]);

        Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . $request->user()->api_token->access_token,
            'Content-Type' => 'application/json',
        ])->post('https://www.zohoapis.eu/crm/v5/Deals', [
            'data' => [
                [
                    'Deal_Name' => $deal['name'],
                    'Stage' => $deal['stage'] //Actual stage name like "Qualification"
                ]
            ]
        ]);

        return back();
    }
}

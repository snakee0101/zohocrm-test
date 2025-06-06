<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if(! auth()->user()->api_token) {
            $queryParams = http_build_query([
                'response_type' => 'code',
                'client_id' => '1000.7DBABT5NN8EJYMLJABQVIMHIUGHIGT',
                'redirect_uri' => 'http://127.0.0.1:8000/oauthredirect',
                'scope' => 'ZohoCRM.modules.ALL,ZohoCRM.settings.ALL',
                'access_type' => 'offline',
            ]);

            $authUrl = "https://accounts.zoho.com/oauth/v2/auth?$queryParams";
            
            return redirect($authUrl);
        }

        $dealStages = Cache::rememberForever('dealStages', function () {
            $response = Http::withHeaders([
                'Authorization' => 'Zoho-oauthtoken ' . auth()->user()->api_token->access_token,
                'Content-Type' => 'application/json',
            ])->get(auth()->user()->api_token->api_domain . '/crm/v5/settings/fields?module=Deals&include=allowed_permissions_to_update');
 
            return array_key_exists('fields', $response->json()) ? collect($response->json()['fields'])->filter(function($field) {
                return $field['field_label'] == 'Stage';
            })->first()['pick_list_values'] : [];
        });
        
        return Inertia::render('Dashboard', [
            'user' => auth()->user(),
            'deal_stages' => $dealStages
        ]);
    }
}

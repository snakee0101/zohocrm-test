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

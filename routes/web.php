<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealController;
use App\Http\Controllers\AccessTokenController;
use App\Http\Controllers\OAuthRedirectController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    $response = Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . auth()->user()->api_token->access_token,
            'Content-Type' => 'application/json',
    ])->get(auth()->user()->api_token->api_domain . '/crm/v5/settings/fields?module=Deals&include=allowed_permissions_to_update');

    $dealStages = collect($response->json()['fields'])->filter(function($field) {
        return $field['field_label'] == 'Stage';
    })->first()['pick_list_values'];
    
    return Inertia::render('Dashboard', [
        'user' => auth()->user(),
        'deal_stages' => $dealStages
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/oauthredirect', OAuthRedirectController::class);
Route::post('/access_token', [AccessTokenController::class, 'store']);

Route::post('/deal', [DealController::class, 'store'])->middleware('auth');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

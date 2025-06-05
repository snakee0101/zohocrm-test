<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use Illuminate\Http\Request;

class AccessTokenController extends Controller
{
    public function store(Request $request)
    {
        $apiResponse = json_decode($request->apiResponse);

        ApiToken::where([
            'user_id' => $request->user()->id
        ])->update([
              "access_token" => $apiResponse->access_token,
              "refresh_token" => $apiResponse->refresh_token ?? null,
              "api_domain" => $apiResponse->api_domain,
              "expires_in" => $apiResponse->expires_in
        ]);

        return redirect()->route('dashboard');
    }
}

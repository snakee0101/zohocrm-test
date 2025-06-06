<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use Illuminate\Http\Request;

class OAuthRedirectController extends Controller
{
    public function __invoke(Request $request)
    {
        ApiToken::updateOrCreate([
            'user_id' => $request->user()->id
        ], [
            'authorization_code' => $request->code,
            'api_domain' => $request['accounts-server']
        ]);

        return redirect()->route('dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DealController extends Controller
{
    public function store(Request $request)
    {
        ['deal' => $deal, 'account' => $account] = $request->all();

        
    }
}

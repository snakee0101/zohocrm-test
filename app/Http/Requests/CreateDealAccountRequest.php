<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDealAccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'account.name' => ['required'],
            'account.phone' => ['required'],
            'account.website' => ['required'],
            'deal.name' => ['required'],
            'deal.stage' => ['required'],
            'deal.closing_date' => ['required', 'date-format:Y-m-d'],
        ];
    }
}

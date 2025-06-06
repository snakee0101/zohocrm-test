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
            'account.website' => ['required', 'url:http,https'],
            'deal.name' => ['required'],
            'deal.stage' => ['required'],
            'deal.closing_date' => ['required', 'date-format:Y-m-d'],
        ];
    }

    public function messages()
    {
        return [
            'account.name' => 'Account name is required',
            'account.phone' => 'Account phone is required',
            'account.website.required' => 'Account website is required',
            'account.website.url' => 'Account website must be a valid URL',
            'deal.name' => 'Deal name is required',
            'deal.stage' => 'Select the deal stage',
            'deal.closing_date.required' => 'Closing date is required',
            'deal.closing_date.date-format' => 'Closing date must be in the format YYYY-MM-DD'
        ];
    }
}

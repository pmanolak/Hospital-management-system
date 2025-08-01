<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendStockAlertRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'recipient_email' => 'required|email'
        ];
    }
}
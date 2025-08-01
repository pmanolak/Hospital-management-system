<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendAppointmentReminderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'appointment_id' => 'required|exists:appointments,id'
        ];
    }
}
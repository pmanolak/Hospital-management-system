<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [

            'id' => $this->id,
            'patient_name' => optional($this->patient)->name,
            'doctor_name' => optional($this->doctor)->name,
            'appointment_time' => $this->appointment_time,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
        ];
    }
}


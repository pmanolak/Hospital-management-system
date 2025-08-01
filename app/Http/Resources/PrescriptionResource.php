<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'appointment_id' => $this->appointment_id,
            'medicines' => $this->medicines,
            'instructions' => $this->instructions,
            'created_at' => $this->created_at,
        ];
    }
}


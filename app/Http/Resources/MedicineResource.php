<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicineResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'quantity'        => $this->quantity,
            'expiry_date'     => $this->expiry_date,
            'stock_threshold' => $this->stock_threshold,
            'notes'           => $this->notes,
        ];
    }
}

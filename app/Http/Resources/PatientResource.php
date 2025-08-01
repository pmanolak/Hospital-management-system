<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'email'  => $this->email ?? null,
            'gender' => $this->gender,
            'dob'    => $this->dob,
            'phone'  => $this->phone,
            'address'=> $this->address,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}

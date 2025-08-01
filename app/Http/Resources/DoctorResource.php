<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource {


    public function toArray($request) {

        return [

            'id'             => $this->id,
            'name'           => $this->name,
            'email'          => $this->email,
            'specialization' => $this->specialization,
            'availability'   => $this->availability,
            'phone'          => $this->phone,
        ];
    }
}
    


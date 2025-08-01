<?php

namespace App\DTO;

class CreatePrescriptionDTO
{
    public function __construct(
        public int $appointment_id,
        public array $medicines,
        public ?string $instructions
    ) {}

    public function toArray(): array
    {
        return [
            'appointment_id' => $this->appointment_id,
            'medicines' => json_encode($this->medicines),            
            'instructions' => $this->instructions,
        ];
    }
}

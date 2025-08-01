<?php

namespace App\DTO;

class CreateMedicineAlertDTO
{
    public string $name;
    public int $quantity;
    public ?string $expiry_date;

    public function __construct(string $name, int $quantity, ?string $expiry_date = null)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->expiry_date = $expiry_date;
    }
}



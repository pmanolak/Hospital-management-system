<?php

namespace App\DTO;

class CreateStockAlertDTO {
    public array $medicines;
    public string $recipientEmail;

    public function __construct(array $medicines, string $recipientEmail)
    {
        $this->medicines = $medicines;
        $this->recipientEmail = $recipientEmail;
    }
}



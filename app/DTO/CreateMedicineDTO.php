<?php

namespace App\DTO;

class CreateMedicineDTO {
    public function __construct(
        public string $name,
        public int $quantity,
        public string $expiry_date,
        public int $stock_threshold,
        public ?string $notes = null,
    ) {}
}

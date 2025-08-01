<?php

namespace App\DTO;

class CreatePatientDTO {
    public function __construct(
        public string $name,
        public string $email,
        public string $gender,
        public string $dob,
        public string $phone,
        public ?string $address = null
    ) {}
}

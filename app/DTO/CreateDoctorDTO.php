<?php

namespace App\DTO;

class CreateDoctorDTO {
    public function __construct(
        public string $name,
        public string $email,
        public string $specialization,
        public ?string $availability = null,
        public string $phone
    ) {}
}



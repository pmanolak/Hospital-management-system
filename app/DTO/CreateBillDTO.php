<?php
namespace App\DTO;

class CreateBillDTO
{
    public function __construct(
        public int $patient_id,
        public float $consultation_fee,
        public float $lab_test_fee,
        public float $medicine_fee
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['patient_id'],
            $data['consultation_fee'],
            $data['lab_test_fee'],
            $data['medicine_fee']
        );
    }

    public function toArray(): array
    {
        return [
            'patient_id' => $this->patient_id,
            'consultation_fee' => $this->consultation_fee,
            'lab_test_fee' => $this->lab_test_fee,
            'medicine_fee' => $this->medicine_fee
        ];
    }
}

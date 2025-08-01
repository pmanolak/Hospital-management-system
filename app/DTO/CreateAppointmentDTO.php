<?php

namespace App\DTO;

use App\Http\Requests\StoreAppointmentRequest;

class CreateAppointmentDTO
{
    public $patient_id;
    public $doctor_id;
    public $appointment_time;
    public $notes;

    public function __construct($patient_id, $doctor_id, $appointment_time, $notes)
    {
        $this->patient_id = $patient_id;
        $this->doctor_id = $doctor_id;
        $this->appointment_time = $appointment_time;
        $this->notes = $notes;
    }

    public static function fromRequest(StoreAppointmentRequest $request): self
    {
        return new self(
            $request->input('patient_id'),
            $request->input('doctor_id'),
            $request->input('appointment_time'),
            $request->input('notes')
        );
    }
}




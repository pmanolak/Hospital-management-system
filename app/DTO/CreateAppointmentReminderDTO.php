<?php

namespace App\DTO;

use Carbon\Carbon;

class CreateAppointmentReminderDTO
{
    public function __construct(
        public string $patientName,
        public string $patientEmail,
        public Carbon $appointmentTime,
        public string $doctorName
    ) {}
}
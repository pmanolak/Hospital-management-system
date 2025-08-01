<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $patientName;
    public string $status;

    public function __construct(string $patientName, string $status)
    {
        $this->patientName = $patientName;
        $this->status = $status;
    }

    public function build()
    {
        $message = "Hello {$this->patientName}, your appointment has been {$this->status}.";

        return $this->subject("Appointment {$this->status}")
                    ->text('emails.plain-appointment-status')
                    ->with(['message' => $message]);
    }
}

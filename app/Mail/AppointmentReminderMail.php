<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class AppointmentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $patient;
    public $appointment;

    public function __construct($patient, $appointment)
    {
        $this->patient = $patient;
        $this->appointment = $appointment;
    }

    public function build()
    {
        $formattedTime = Carbon::parse($this->appointment->appointment_time)->format('F j, Y \a\t g:i A');

        $body = "Hello {$this->patient->name},\n\n";
        $body .= "This is a reminder for your appointment with Dr. {$this->appointment->doctor->name} ";
        $body .= "scheduled on {$formattedTime}.\n\n";
        $body .= "Please arrive 10 minutes early.\n\n";
        $body .= "Thank you,\nHospital Management System";

        return $this->subject('Appointment Reminder')
                    ->text('emails.plain-text')  
                    ->with(['body' => $body]);
    }
}

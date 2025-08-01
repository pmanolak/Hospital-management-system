<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Appointment;

class AppointmentStatusNotification extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment->loadMissing('doctor');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $doctorName = $this->appointment->doctor?->name ?? 'Unknown';

        return (new MailMessage)
            ->subject('Appointment Status Updated')
            ->greeting("Hello {$notifiable->name},")
            ->line("Your appointment scheduled at {$this->appointment->appointment_time} has been '{$this->appointment->status}'.")
            ->line("Doctor: {$doctorName}")
            ->line("Thank you for using our Hospital Management System.");
    }
}

<?php

namespace App\Services;

use App\DTO\CreateAppointmentReminderDTO;
use App\DTO\CreateStockAlertDTO;
use App\Mail\AppointmentReminderMail;
use App\Mail\StockAlertMail;
use App\Mail\AppointmentStatusMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class NotificationService
{
    public function sendAppointmentReminder(CreateAppointmentReminderDTO $dto)
    {
        $formattedTime = Carbon::parse($dto->appointmentTime)->format('F j, Y \a\t g:i A');
        $message = "Hello {$dto->patientName},\n\n";
        $message .= "This is a reminder for your appointment with Dr. {$dto->doctorName} ";
        $message .= "scheduled on {$formattedTime}.\n\n";
        $message .= "Please arrive 10 minutes early.\n\nThank you,\nHospital Management System";
        Mail::raw($message, function ($mail) use ($dto) {
            $mail->to($dto->patientEmail)
            ->subject('Appointment Reminder');
        });
    }

    public function sendStockAlert(CreateStockAlertDTO $dto): void
    {
        Mail::to($dto->recipientEmail)
            ->send(new StockAlertMail($dto->medicines));
    }

    public function sendAppointmentStatusEmail(string $email, string $patientName, string $status): void
    {
        Mail::raw("Hello {$patientName}, your appointment has been {$status}.", function ($message) use ($email, $status) {
            $message->to($email)
                    ->subject("Appointment {$status}");
        });

    }
}

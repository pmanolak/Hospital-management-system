<?php
namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReminderMail;
use Carbon\Carbon;

class ReminderService
{
    public function sendUpcomingReminders(): int
    {
        $appointments = Appointment::with('patient', 'doctor')
            ->whereBetween('appointment_time', [
                Carbon::now(),
                Carbon::now()->addDay()
            ])->get();

        foreach ($appointments as $appointment) {
            Mail::to($appointment->patient->email)
                ->send(new AppointmentReminderMail($appointment->patient, $appointment));
        }

        return $appointments->count();
    }
}

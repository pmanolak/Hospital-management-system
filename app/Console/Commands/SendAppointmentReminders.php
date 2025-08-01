<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReminderMail;

class SendAppointmentReminders extends Command
{
    protected $signature = 'reminders:appointments';
    protected $description = 'Send email reminders for appointments happening tomorrow';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow();

        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_time', $tomorrow)
            ->where('status', 'approved')  
            ->get();

        foreach ($appointments as $appt) {
            if ($appt->patient && $appt->patient->email) {
                Mail::to($appt->patient->email)->send(new AppointmentReminderMail($appt->patient, $appt));
            }
        }

        $this->info("Reminders sent for " . $appointments->count() . " appointments.");
    }
}

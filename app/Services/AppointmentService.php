<?php

namespace App\Services;

use App\Models\Appointment;
use App\DTO\CreateAppointmentDTO;
use App\DTO\CreateAppointmentReminderDTO;
use Illuminate\Validation\ValidationException;
use App\Services\NotificationService;
use Carbon\Carbon;
use App\Filters\DoctorFilter;
use App\Filters\PatientFilter;
use App\Filters\AppointmentStatusFilter;
use App\Filters\DateFilter;
use App\Helpers\FilterPipeline;

class AppointmentService
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function all()
    {
        return Appointment::with(['patient', 'doctor'])->latest()->get();
    }

    public function find($id)
    {
        return Appointment::with(['patient', 'doctor'])->findOrFail($id);
    }

    public function create(CreateAppointmentDTO $dto)
    {
        $this->ensureNotDoubleBooked($dto);

        $appointment = Appointment::create([
            'patient_id'       => $dto->patient_id,
            'doctor_id'        => $dto->doctor_id,
            'appointment_time' => $dto->appointment_time,
            'notes'            => $dto->notes,
            'status'           => 'pending',
        ]);

        return $appointment->load(['patient', 'doctor']);
    }

    public function update($id, CreateAppointmentDTO $dto)
    {
        $this->ensureNotDoubleBooked($dto, $id);

        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'patient_id'       => $dto->patient_id,
            'doctor_id'        => $dto->doctor_id,
            'appointment_time' => $dto->appointment_time,
            'notes'            => $dto->notes,
        ]);

        return $appointment->load(['patient', 'doctor']);
    }

    public function delete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
    }

    public function updateStatus(int $id, string $status): Appointment
    {
        $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($id);
        $appointment->status = $status;
        $appointment->save();

        if ($appointment->patient && $appointment->patient->email) {
            $this->notificationService->sendAppointmentStatusEmail(
                email: $appointment->patient->email,
                patientName: $appointment->patient->name,
                status: $status
            );
        }

        return $appointment;
    }

    protected function ensureNotDoubleBooked(CreateAppointmentDTO $dto, $excludeId = null)
    {
        $query = Appointment::where('doctor_id', $dto->doctor_id)
            ->where('appointment_time', $dto->appointment_time)
            ->where('status', '!=', 'rejected');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'appointment_time' => 'Doctor already booked at this time.',
            ]);
        }
    }

    public function sendRemindersForUpcomingAppointments(array $filters = []): int
    {
        $filterMap = [
            'doctor_id'  => DoctorFilter::class,
            'patient_id' => PatientFilter::class,
            'status'     => AppointmentStatusFilter::class,
            'date'       => DateFilter::class,
        ];

        $now = Carbon::now();
        $start = $now->copy()->addHour()->subMinutes(5);    
        $end = $now->copy()->addHour()->addMinutes(5);      

        $query = Appointment::with(['patient', 'doctor'])
            ->where('status', 'approved')
            ->whereBetween('appointment_time', [$start, $end]);

        $appointments = FilterPipeline::apply($query, $filters, $filterMap)->get();

        foreach ($appointments as $appointment) {
            if ($appointment->patient && $appointment->patient->email) {
                $this->notificationService->sendAppointmentReminder(
                    new CreateAppointmentReminderDTO(
                        patientName: $appointment->patient->name,
                        patientEmail: $appointment->patient->email,
                        doctorName: $appointment->doctor->name,
                        appointmentTime: $appointment->appointment_time
                    )
                );
            }
        }

        return $appointments->count();
    }

    public function getFilteredAppointments(array $filters)
    {
        $filterMap = [
            'doctor_id'  => DoctorFilter::class,
            'patient_id' => PatientFilter::class,
            'status'     => AppointmentStatusFilter::class,
            'date'       => DateFilter::class,
        ];

        $query = Appointment::with(['doctor', 'patient'])->latest();

        return FilterPipeline::apply($query, $filters, $filterMap)->paginate();
    }
}

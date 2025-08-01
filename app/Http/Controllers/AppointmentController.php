<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentStatusRequest;
use App\Http\Resources\AppointmentResource;
use App\Services\AppointmentService;
use App\Services\ReminderService;
use App\Services\NotificationService;
use App\DTO\CreateAppointmentDTO;
use App\DTO\CreateAppointmentReminderDTO;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    protected AppointmentService $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['doctor_id', 'patient_id', 'status', 'date']);
        $appointments = $this->appointmentService->getFilteredAppointments($filters);
        return AppointmentResource::collection($appointments);
    }

    public function store(StoreAppointmentRequest $request)
    {
        $dto = CreateAppointmentDTO::fromRequest($request);
        $appointment = $this->appointmentService->create($dto);
        return new AppointmentResource($appointment);
    }

    public function show($id)
    {
        return new AppointmentResource($this->appointmentService->find($id));
    }

    public function update(StoreAppointmentRequest $request, $id)
    {
        $dto = CreateAppointmentDTO::fromRequest($request);
        $appointment = $this->appointmentService->update($id, $dto);
        return new AppointmentResource($appointment);
    }

    public function destroy($id)
    {
        $this->appointmentService->delete($id);
        return response()->json(['message' => 'Appointment deleted successfully']);
    }

    public function updateStatus(UpdateAppointmentStatusRequest $request, $id)
    {
        $status = $request->validated()['status'];
        $appointment = $this->appointmentService->updateStatus($id, $status);
        return new AppointmentResource($appointment);
    }

    public function sendReminders(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
        ]);

        $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($request->appointment_id);

        if ($appointment->patient && $appointment->patient->email) {
            app(NotificationService::class)->sendAppointmentReminder(
                new CreateAppointmentReminderDTO(
                    patientName: $appointment->patient->name,
                    patientEmail: $appointment->patient->email,
                    doctorName: $appointment->doctor->name,
                    appointmentTime: Carbon::parse($appointment->appointment_time)  
                    )
            );

            return response()->json(['message' => 'Reminder sent.']);
        }

        return response()->json(['message' => 'No reminder sent.']);
    }
}

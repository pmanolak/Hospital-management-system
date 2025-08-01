<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ExportController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::get('profile', function (Request $request) {
        return response()->json($request->user());
    });

    Route::post('logout', [AuthController::class, 'logout']);

    // Patients
    Route::get('patients', [PatientController::class, 'index']);
    Route::post('patients', [PatientController::class, 'store']);
    Route::put('patients/{id}', [PatientController::class, 'update']);  
    Route::delete('patients/{id}', [PatientController::class, 'destroy']);

    // Doctors
    Route::get('doctors', [DoctorController::class, 'index']);
    Route::post('doctors', [DoctorController::class, 'store']);
    Route::put('doctors/{id}', [DoctorController::class, 'update']);
    Route::delete('doctors/{id}', [DoctorController::class, 'destroy']);

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
    Route::patch('/appointments/{id}/status', [AppointmentController::class, 'updateStatus']);
    Route::post('/appointments/reminders/send', [AppointmentController::class, 'sendReminders']);


    // Medicines
    Route::get('/medicines', [MedicineController::class, 'index']);
    Route::post('/medicines', [MedicineController::class, 'store']);
    Route::put('/medicines/{id}', [MedicineController::class, 'update']);
    Route::delete('/medicines/{id}', [MedicineController::class, 'destroy']);

    Route::get('/medicines/low-stock', [MedicineController::class, 'lowStock']);
    Route::get('/medicines/expiring-soon', [MedicineController::class, 'expiringSoon']);
    Route::get('/medicines/{id}', [MedicineController::class, 'show']);
    Route::post('/medicines/trigger-stock-alert', [MedicineController::class, 'triggerStockAlert']);

    // Bills 
    Route::get('/bills', [BillController::class, 'index']);
    Route::post('/bills', [BillController::class, 'store']);
    Route::get('/bills/{bill}', [BillController::class, 'show']);
    Route::put('/bills/{bill}', [BillController::class, 'update']); 
    Route::delete('/bills/{id}', [BillController::class, 'destroy']);

    // Prescriptions
    Route::get('/prescriptions', [PrescriptionController::class, 'index']);
    Route::post('/prescriptions', [PrescriptionController::class, 'store']);
    Route::get('/prescriptions/{prescription}', [PrescriptionController::class, 'show']);
    Route::put('/prescriptions/{prescription}', [PrescriptionController::class, 'update']);
    Route::delete('/prescriptions/{id}', [PrescriptionController::class, 'destroy']);

    // Excel Exports
    Route::get('/export/bills', [ExportController::class, 'exportBills']);
    Route::get('/export/prescriptions', [ExportController::class, 'exportPrescriptions']);
    Route::get('/export/medicines', [ExportController::class, 'exportMedicines']);

    // PDF & Email
    Route::post('/email-bills-pdf', [ExportController::class, 'emailBillsPdf']);});

    Route::get('/test-error', function () {
        throw new \Exception("Sample exception for error log test");
    });
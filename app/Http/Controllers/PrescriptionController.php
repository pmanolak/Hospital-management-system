<?php

namespace App\Http\Controllers;

use App\DTO\CreatePrescriptionDTO;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Services\PrescriptionService;
use App\Http\Resources\PrescriptionResource;
use App\Http\Requests\StorePrescriptionRequest;

class PrescriptionController extends Controller
{
    public function index(Request $request, PrescriptionService $service)
    {
        $prescriptions = $service->getFilteredPrescriptions($request->all());
        return PrescriptionResource::collection($prescriptions);
    }

    public function store(StorePrescriptionRequest $request, PrescriptionService $service)
    {
        $dto = new CreatePrescriptionDTO(...$request->validated());
        $prescription = $service->create($dto);
        return new PrescriptionResource($prescription);
    }

    public function show(Prescription $prescription)
    {
        return new PrescriptionResource($prescription);
    }

    public function update(StorePrescriptionRequest $request, Prescription $prescription, PrescriptionService $service)
    {
        $dto = new CreatePrescriptionDTO(...$request->validated());
        $prescription = $service->update($dto, $prescription);
        return new PrescriptionResource($prescription);
    }

    public function destroy(Prescription $prescription, PrescriptionService $service)
    {
        $service->delete($prescription);
        return response()->json(['message' => 'Prescription deleted']);
    }
}

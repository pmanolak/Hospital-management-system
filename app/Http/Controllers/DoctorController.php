<?php

namespace App\Http\Controllers;

use App\DTO\CreateDoctorDTO;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Services\DoctorService;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    protected DoctorService $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

     
    public function index(Request $request)
    {
         
        $filters = $request->only(['name', 'specialization', 'availability']);

        $doctors = $this->doctorService->getFilteredDoctors($filters);

        return DoctorResource::collection($doctors);
    }

     
    public function store(StoreDoctorRequest $request)
    {
        $dto = new CreateDoctorDTO(
            $request->input('name'),
            $request->input('email'),
            $request->input('specialization'),
            $request->input('availability'),
            $request->input('phone')
        );

        $doctor = $this->doctorService->create($dto);

        return new DoctorResource($doctor);
    }

     
    public function update(StoreDoctorRequest $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $dto = new CreateDoctorDTO(
            $request->input('name'),
            $request->input('email'),
            $request->input('specialization'),
            $request->input('availability'),
            $request->input('phone')
        );

        $updatedDoctor = $this->doctorService->update($doctor, $dto);

        return new DoctorResource($updatedDoctor);
    }

    public function destroy($id)
    {
        $this->doctorService->softDelete($id);

        return response()->json(['message' => 'Doctor soft-deleted successfully']);
    }
}

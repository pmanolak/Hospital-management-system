<?php
namespace App\Http\Controllers;
use App\Models\Patient;
use App\DTO\CreatePatientDTO;
use App\Services\PatientService;
use App\Http\Resources\PatientResource;
use App\Http\Requests\StorePatientRequest;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected PatientService $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->middleware('auth:api');
        $this->patientService = $patientService;
    }

    public function index(Request $request)
    {
        $patients = $this->patientService->getFilteredPatients($request->all());
        return PatientResource::collection($patients);
    }

    public function store(StorePatientRequest $request)
    {
        $dto = new CreatePatientDTO(...$request->only([
            'name', 'email', 'gender', 'dob', 'phone', 'address'
        ]));

        $patient = $this->patientService->create($dto);

        return new PatientResource($patient);
    }

    public function update(StorePatientRequest $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $dto = new CreatePatientDTO(...$request->only([
            'name', 'email', 'gender', 'dob', 'phone', 'address'
        ]));

        $updatedPatient = $this->patientService->update($patient, $dto);

        return new PatientResource($updatedPatient);
    }

    public function destroy($id)
    {
        $this->patientService->softDelete($id);
        return response()->json(['message' => 'Patient soft-deleted successfully']);
    }
}

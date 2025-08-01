<?php
namespace App\Services;

use App\Models\Patient;
use App\DTO\CreatePatientDTO;
use App\Helpers\FilterPipeline;
use App\Filters\NameFilter;
use App\Filters\GenderFilter;
use App\Filters\StatusFilter;

class PatientService
{
    public function create(CreatePatientDTO $dto): Patient
    {
        return Patient::create([
            'name'    => $dto->name,
            'email'   => $dto->email,
            'gender'  => $dto->gender,
            'dob'     => $dto->dob,
            'phone'   => $dto->phone,
            'address' => $dto->address,
            'user_id' => auth()->id(),
        ]);
    }

    public function update(Patient $patient, CreatePatientDTO $dto): Patient
    {
        $patient->update([
            'name'    => $dto->name,
            'email'   => $dto->email,
            'gender'  => $dto->gender,
            'dob'     => $dto->dob,
            'phone'   => $dto->phone,
            'address' => $dto->address,
        ]);

        return $patient;
    }

    public function softDelete($id)
    {
        $patient = Patient::withTrashed()->findOrFail($id);  
        $patient->delete();  
    }

    public function getFilteredPatients(array $filters)
    {
        $filterMap = [
            'name'   => NameFilter::class,
            'gender' => GenderFilter::class,
            'status' => StatusFilter::class,  
        ];
        $query = Patient::withTrashed();  
        return FilterPipeline::apply($query, $filters, $filterMap)->paginate();
    }

}

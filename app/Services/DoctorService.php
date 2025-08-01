<?php

namespace App\Services;

use App\Models\Doctor;
use App\DTO\CreateDoctorDTO;
use App\Helpers\FilterPipeline;
use App\Filters\NameFilter;
use App\Filters\SpecializationFilter;
use App\Filters\AvailabilityFilter;

class DoctorService
{
    public function create(CreateDoctorDTO $dto): Doctor
    {
        return Doctor::create([
            'name'           => $dto->name,
            'email'          => $dto->email,
            'specialization' => $dto->specialization,
            'availability'   => $dto->availability,
            'phone'          => $dto->phone,
            'user_id'        => auth()->id(),
        ]);
    }

    public function update(Doctor $doctor, CreateDoctorDTO $dto): Doctor
    {
        $doctor->update([
            'name'           => $dto->name,
            'email'          => $dto->email,
            'specialization' => $dto->specialization,
            'availability'   => $dto->availability,
            'phone'          => $dto->phone,
        ]);

        return $doctor;
    }

    public function softDelete($id)
    {
        $doctor = Doctor::withTrashed()->findOrFail($id);
        $doctor->delete();  
    }

    public function getFilteredDoctors(array $filters)
    {
        $filterMap = [
            'name'           => NameFilter::class,
            'specialization' => SpecializationFilter::class,
            'availability'   => AvailabilityFilter::class,
        ];

        $query = Doctor::withTrashed();  
        return FilterPipeline::apply($query, $filters, $filterMap)->paginate();
    }
}

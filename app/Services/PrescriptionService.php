<?php

namespace App\Services;

use App\Models\Prescription;
use App\DTO\CreatePrescriptionDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\FilterPipeline;
use App\Filters\DateFilter;
use App\Filters\AppointmentIdFilter;

class PrescriptionService
{
    public function create(CreatePrescriptionDTO $dto): Prescription
    {
        return Prescription::create([
            'appointment_id' => $dto->appointment_id,
            'medicines' => $dto->medicines,
            'instructions' => $dto->instructions,
        ]);
    }

    public function update(CreatePrescriptionDTO $dto, Prescription $prescription): Prescription
    {
        $prescription->update([
            'appointment_id' => $dto->appointment_id,
            'medicines' => $dto->medicines,
            'instructions' => $dto->instructions,
        ]);

        return $prescription;
    }

    public function delete(Prescription $prescription): void
    {
        $prescription->delete();
    }

    public function getFilteredPrescriptions(array $filters): LengthAwarePaginator
    {
        $filterMap = [
            'date' => DateFilter::class,
            'appointment_id' => AppointmentIdFilter::class,
        ];

        $query = Prescription::with(['appointment'])->latest();

        return FilterPipeline::apply($query, $filters, $filterMap)->paginate();
    }
}

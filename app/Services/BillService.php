<?php

namespace App\Services;

use App\Models\Bill;
use App\DTO\CreateBillDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\FilterPipeline;
use App\Filters\DateFilter;
use App\Filters\PatientIdFilter;

class BillService
{
    public function create(CreateBillDTO $dto): Bill
    {
        $total = $dto->consultation_fee + $dto->lab_test_fee + $dto->medicine_fee;

        return Bill::create([
            'patient_id' => $dto->patient_id,
            'consultation_fee' => $dto->consultation_fee,
            'lab_test_fee' => $dto->lab_test_fee,
            'medicine_fee' => $dto->medicine_fee,
            'total_amount' => $total,
        ]);
    }

    public function update(CreateBillDTO $dto, Bill $bill): Bill
    {
        $total = $dto->consultation_fee + $dto->lab_test_fee + $dto->medicine_fee;

        $bill->update([
            'patient_id' => $dto->patient_id,
            'consultation_fee' => $dto->consultation_fee,
            'lab_test_fee' => $dto->lab_test_fee,
            'medicine_fee' => $dto->medicine_fee,
            'total_amount' => $total,
        ]);

        return $bill;
    }

    public function delete(Bill $bill): void
    {
        $bill->delete();
    }

    public function getFilteredBills(array $filters): LengthAwarePaginator
    {
        $filterMap = [
            'date' => DateFilter::class,
            'patient_id' => PatientIdFilter::class,
        ];

        $query = Bill::with('patient')->latest();

        return FilterPipeline::apply($query, $filters, $filterMap)->paginate();
    }
}

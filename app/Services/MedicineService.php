<?php

namespace App\Services;

use App\Models\Medicine;
use App\DTO\CreateMedicineDTO;
use Illuminate\Support\Collection;
use App\Helpers\FilterPipeline;
use App\Filters\ExpiryDateFilter;
use App\Filters\LowStockFilter;
use App\Filters\NameFilter;

class MedicineService
{
    public function getAll(): Collection
    {
        return Medicine::all();
    }

    public function create(CreateMedicineDTO $dto): Medicine
    {
        return Medicine::create([
            'name'            => $dto->name,
            'quantity'        => $dto->quantity,
            'expiry_date'     => $dto->expiry_date,
            'stock_threshold' => $dto->stock_threshold,
            'notes'           => $dto->notes
        ]);
    }

    public function getLowStock(): Collection
    {
        return Medicine::whereColumn('quantity', '<=', 'stock_threshold')->get();
    }

    public function getExpiringSoon(): Collection
    {
        return Medicine::whereBetween('expiry_date', [now(), now()->addDays(30)])->get();
    }

    public function delete(int $id): void
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();
    }

    public function getById(int $id): Medicine
    {
        return Medicine::findOrFail($id);
    }

    public function update(int $id, CreateMedicineDTO $dto): Medicine
    {
        $medicine = Medicine::findOrFail($id);

        $medicine->update([
            'name'            => $dto->name,
            'quantity'        => $dto->quantity,
            'expiry_date'     => $dto->expiry_date,  
            'stock_threshold' => $dto->stock_threshold,
            'notes'           => $dto->notes
        ]);

        return $medicine;
    }

    public function getAlertWorthyMedicines(): Collection
    {
        return Medicine::whereColumn('quantity', '<=', 'stock_threshold')
            ->orWhereBetween('expiry_date', [now(), now()->addDays(30)])
            ->get()
            ->unique('id');
    }

    public function getCombinedAlerts(): Collection
    {
        return $this->getLowStock()
            ->merge($this->getExpiringSoon())
            ->unique('id');
    }

    public function getFilteredMedicines(array $filters)
    {
        $filterMap = [
            'expiry_date'  => ExpiryDateFilter::class,
            'low_stock'    => LowStockFilter::class,
            'name'         => NameFilter::class,
        ];

        $query = Medicine::query()->latest();

        return FilterPipeline::apply($query, $filters, $filterMap)->paginate();
    }
}

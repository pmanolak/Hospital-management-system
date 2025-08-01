<?php

namespace App\Services;

use App\Models\Medicine;
use App\Exports\MedicinesExport;
use App\Filters\DateFilter;
use App\Filters\ExpiryDateFilter;
use App\Helpers\FilterPipeline;
use Maatwebsite\Excel\Facades\Excel;

class MedicineExportService
{
    public function export(array $filters)
    {
        $query = Medicine::select('*');

        $filteredQuery = FilterPipeline::apply($query, $filters, [
            'expiry_date' => ExpiryDateFilter::class,
            'date' => DateFilter::class,
        ]);

        return Excel::download(new MedicinesExport($filteredQuery->get()), 'medicines.xlsx');
    }
}

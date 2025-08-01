<?php

namespace App\Services;

use App\Models\Prescription;
use App\Exports\PrescriptionsExport;
use App\Filters\DateFilter;
use App\Filters\AppointmentIdFilter;
use App\Helpers\FilterPipeline;
use Maatwebsite\Excel\Facades\Excel;

class PrescriptionExportService
{
    public function export(array $filters)
    {
        $query = Prescription::with('appointment.patient', 'appointment.doctor')->select('*');

        $filteredQuery = FilterPipeline::apply($query, $filters, [
            'date' => DateFilter::class,
            'appointment_id' => AppointmentIdFilter::class,
        ]);

        return Excel::download(new PrescriptionsExport($filteredQuery->get()), 'prescriptions.xlsx');
    }
}

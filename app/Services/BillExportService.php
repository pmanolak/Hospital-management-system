<?php

namespace App\Services;

use App\Models\Bill;
use App\Exports\BillsExport;
use App\Filters\DateFilter;
use App\Filters\PatientIdFilter;
use App\Helpers\FilterPipeline;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class BillExportService
{
    public function export(array $filters)
    {
        $query = Bill::with('patient')->select('*');
        
        $filteredQuery = FilterPipeline::apply($query, $filters, [
            'date' => DateFilter::class,
            'patient_id' => PatientIdFilter::class,
        ]);

        return Excel::download(new BillsExport($filteredQuery->get()), 'bills.xlsx');
    }

    public function generatePdfReport()
    {
        $bills = Bill::with('patient')->get();

        $report = "Bills Report\n\n";
        $report .= "Patient\t\tTotal\t\tDate\n";
        $report .= "-----------------------------------------\n";

        foreach ($bills as $bill) {
            $report .= $bill->patient->name . "\t\t" . $bill->total_amount . "\t\t" . $bill->created_at->format('Y-m-d') . "\n";
        }

        $pdf = Pdf::loadHTML('<pre>' . e($report) . '</pre>');
        return $pdf->output();
    }
}

<?php
namespace App\Exports;

use App\Models\Bill;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BillsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Bill::select('id', 'patient_id', 'consultation_fee', 'lab_test_fee', 'medicine_fee', 'total_amount', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Patient ID', 'Consultation Fee', 'Lab Test Fee', 'Medicine Fee', 'Total Amount', 'Created At'];
    }
}

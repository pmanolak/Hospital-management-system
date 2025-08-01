<?php

namespace App\Exports;

use App\Models\Prescription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PrescriptionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Prescription::select('id', 'appointment_id', 'medicines', 'instructions', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Appointment ID', 'Medicines', 'Instructions', 'Created At'];
    }
}

<?php

namespace App\Exports;

use App\Models\Medicine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MedicinesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Medicine::select('id', 'name', 'quantity', 'expiry_date', 'stock_threshold', 'notes', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Quantity',
            'Expiry Date',
            'Stock Threshold',
            'Notes',
            'Created At'
        ];
    }
}



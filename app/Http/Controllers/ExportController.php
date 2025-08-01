<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Services\BillExportService;
use App\Services\MedicineExportService;
use App\Services\PrescriptionExportService;
use App\Mail\BillPdfMail;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    protected $billExportService;
    protected $medicineExportService;
    protected $prescriptionExportService;

    public function __construct(
        BillExportService $billExportService,
        MedicineExportService $medicineExportService,
        PrescriptionExportService $prescriptionExportService
    ) {
        $this->billExportService = $billExportService;
        $this->medicineExportService = $medicineExportService;
        $this->prescriptionExportService = $prescriptionExportService;
    }

    public function exportBills(Request $request)
    {
        $filters = $request->all();  
        return $this->billExportService->export($filters);
    }

    public function exportPrescriptions(Request $request)
    {
        $filters = $request->all();  
        return $this->prescriptionExportService->export($filters);
    }

    public function exportMedicines(Request $request)
    {
        $filters = $request->all();  
        return $this->medicineExportService->export($filters);
    }

    public function emailBillsPdf(Request $request)
    {
        $email = $request->input('email');

        if (!$email) {
            return response()->json(['message' => 'Email address is required.'], 400);
        }

        $pdfContent = $this->billExportService->generatePdfReport();

        Mail::to($email)->send(new BillPdfMail($pdfContent, 'bills_report.pdf'));

        return response()->json(['message' => 'PDF emailed successfully.']);
    }
}

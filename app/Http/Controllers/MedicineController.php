<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMedicineRequest;
use App\Http\Resources\MedicineResource;
use App\DTO\CreateMedicineDTO;
use App\DTO\CreateStockAlertDTO;
use App\DTO\CreateMedicineAlertDTO;
use App\Services\MedicineService;
use App\Services\NotificationService;

class MedicineController extends Controller
{
    protected MedicineService $medicineService;
    protected NotificationService $notificationService;

    public function __construct(
        MedicineService $medicineService,
        NotificationService $notificationService
    ) {
        $this->medicineService = $medicineService;
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $medicines = $this->medicineService->getFilteredMedicines($request->all());
        return MedicineResource::collection($medicines);
    }

    public function store(StoreMedicineRequest $request)
    {
        $dto = new CreateMedicineDTO(
            $request->name,
            $request->quantity,
            $request->expiry_date,
            $request->stock_threshold,
            $request->notes
        );

        $medicine = $this->medicineService->create($dto);

        return new MedicineResource($medicine);
    }

    public function show($id)
    {
        $medicine = $this->medicineService->getById($id);
        return new MedicineResource($medicine);
    }

    public function update(StoreMedicineRequest $request, $id)
    {
        $dto = new CreateMedicineDTO(
            $request->name,
            $request->quantity,
            $request->expiry_date,
            $request->stock_threshold,
            $request->notes
        );

        $medicine = $this->medicineService->update($id, $dto);

        return new MedicineResource($medicine);
    }

    public function destroy($id)
    {
        $this->medicineService->delete($id);
        return response()->json(['message' => 'Medicine deleted']);
    }

    public function lowStock()
    {
        return MedicineResource::collection($this->medicineService->getLowStock());
    }

    public function expiringSoon()
    {
        return MedicineResource::collection($this->medicineService->getExpiringSoon());
    }

    public function triggerStockAlert(Request $request)
    {
        try {
            $alertMedicines = $this->medicineService->getAlertWorthyMedicines();

            if ($alertMedicines->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'No stock alerts to send',
                    'data' => [],
                ]);
            }

            $medicineDTOs = $alertMedicines->map(function ($medicine) {
                return new CreateMedicineAlertDTO(
                    $medicine->name,
                    $medicine->quantity,
                    optional($medicine->expiry_date)->format('Y-m-d')
                );
            })->toArray();

            $this->notificationService->sendStockAlert(
                new CreateStockAlertDTO(
                    $medicineDTOs,
                    config('mail.stock_alert_recipient', 'pharmacy@hospital.com')
                )
            );

            return response()->json([
                'success' => true,
                'message' => 'Stock alert sent successfully',
                'data' => [
                    'medicines_count' => count($medicineDTOs),
                    'recipient' => config('mail.stock_alert_recipient'),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send stock alert',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

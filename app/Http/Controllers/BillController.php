<?php

namespace App\Http\Controllers;

use App\DTO\CreateBillDTO;
use App\Models\Bill;
use Illuminate\Http\Request;
use App\Services\BillService;
use App\Http\Resources\BillResource;
use App\Http\Requests\StoreBillRequest;

class BillController extends Controller
{
    public function index(Request $request, BillService $service)
    {
        $bills = $service->getFilteredBills($request->all());
        return BillResource::collection($bills);
    }

    public function store(StoreBillRequest $request, BillService $service)
    {
        $dto = CreateBillDTO::fromArray($request->validated());
        $bill = $service->create($dto);
        return new BillResource($bill);
    }

    public function show(Bill $bill)
    {
        return new BillResource($bill);
    }

    public function update(StoreBillRequest $request, Bill $bill, BillService $service)
    {
        $dto = CreateBillDTO::fromArray($request->validated());
        $bill = $service->update($dto, $bill);
        return new BillResource($bill);
    }

    public function destroy(Bill $bill, BillService $service)
    {
        $service->delete($bill);
        return response()->json(['message' => 'Bill deleted']);
    }
}

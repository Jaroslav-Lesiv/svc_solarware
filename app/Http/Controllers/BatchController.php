<?php

namespace App\Http\Controllers;

use App\DTO\PurchaseData;
use App\Http\Requests\ProviderRefundRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Resources\BatchProfitResource;
use App\Http\Resources\BatchResource;
use App\Models\Batch;
use App\Services\BatchProfitService;
use App\Services\ProviderRefundService;
use App\Services\PurchaseService;
use Illuminate\Http\JsonResponse;

class BatchController extends Controller
{
    public function store(PurchaseRequest $request, PurchaseService $service): JsonResponse
    {
        $batch = $service->purchase(PurchaseData::fromArray($request->validated()));

        return new JsonResponse(new BatchResource($batch), 201);
    }

    public function profit(BatchProfitService $service): JsonResponse
    {
        return response()->json(BatchProfitResource::collection($service->calculate()));
    }

    public function refund(ProviderRefundRequest $request, Batch $batch, ProviderRefundService $service): JsonResponse
    {
        $service->refund($batch, $request->validated()['products']);

        return new JsonResponse(['message' => 'Refund processed.']);
    }
}

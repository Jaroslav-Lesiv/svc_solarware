<?php

namespace App\Http\Controllers;

use App\DTO\OrderData;
use App\Http\Requests\ClientRefundRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\ClientRefundService;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function store(OrderRequest $request, OrderService $service): JsonResponse
    {
        $order = $service->place(OrderData::fromArray($request->validated()));

        return new JsonResponse(new OrderResource($order), 201);
    }

    public function refund(ClientRefundRequest $request, Order $order, ClientRefundService $service): JsonResponse
    {
        $service->refund($order, $request->validated()['items']);

        return new JsonResponse(['message' => 'Refund recorded.']);
    }
}

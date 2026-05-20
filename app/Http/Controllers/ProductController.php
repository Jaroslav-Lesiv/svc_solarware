<?php

namespace App\Http\Controllers;

use App\Http\Resources\AvailableProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function available(ProductService $service): JsonResponse
    {
        return new JsonResponse(AvailableProductResource::collection($service->available()));
    }
}

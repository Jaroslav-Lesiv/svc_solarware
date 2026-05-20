<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorageRemainingRequest;
use App\Http\Resources\StorageRemainingResource;
use App\Services\StorageService;
use Illuminate\Http\JsonResponse;

class StorageController extends Controller
{
    public function remaining(StorageRemainingRequest $request, StorageService $service): JsonResponse
    {
        $remaining = $service->remainingAt($request->validated()['date']);

        return new JsonResponse(StorageRemainingResource::collection($remaining));
    }
}

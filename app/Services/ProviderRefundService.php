<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\ProviderRefund;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProviderRefundService
{
    public function refund(Batch $batch, array $products): void
    {
        DB::transaction(function () use ($batch, $products) {
            foreach ($products as $item) {
                $batchProduct = $batch->batchProducts()
                    ->where('product_id', $item['id'])
                    ->lockForUpdate()
                    ->first();

                if (! $batchProduct) {
                    abort(422, "product {$item['id']} is not in this batch");
                }

                // available accounts for client returns that came back into this batch
                $available = $batchProduct->availableQty();

                if ($item['qty'] > $available) {
                    throw ValidationException::withMessages([
                        'products' => ["can refund max {$available} units for this product"],
                    ]);
                }

                ProviderRefund::create([
                    'batch_product_id' => $batchProduct->id,
                    'qty' => $item['qty'],
                    'refunded_at' => today()->toDateString(),
                ]);
            }
        });
    }
}

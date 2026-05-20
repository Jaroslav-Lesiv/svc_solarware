<?php

namespace App\Services;

use App\DTO\OrderData;
use App\Models\BatchProduct;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function place(OrderData $data): Order
    {
        return DB::transaction(function () use ($data) {
            $allocations = $this->allocate($data->products);

            $prices = Product::whereIn('id', array_column($data->products, 'productId'))
                ->pluck('price', 'id');

            $order = Order::create(['client_id' => $data->clientId]);

            foreach ($data->products as $item) {
                foreach ($allocations[$item->productId] as $alloc) {
                    $order->items()->create([
                        'batch_product_id' => $alloc['batch_product_id'],
                        'qty' => $alloc['qty'],
                        'unit_price' => $prices[$item->productId],
                    ]);
                }
            }

            return $order->load(['client', 'items.batchProduct.product']);
        });
    }

    private function allocate(array $products): array
    {
        $allocations = [];

        foreach ($products as $item) {
            $needed = $item->qty;
            $batchAllocs = [];

            // consistent lock order avoids deadlock between concurrent orders
            $batchProducts = BatchProduct::join('batches', 'batch_products.batch_id', '=', 'batches.id')
                ->where('batch_products.product_id', $item->productId)
                ->orderBy('batches.purchased_at', 'asc')
                ->orderBy('batches.id', 'asc')
                ->select('batch_products.*')
                ->lockForUpdate()
                ->get();

            foreach ($batchProducts as $bp) {
                if ($needed <= 0) break;

                $available = $bp->availableQty();
                if ($available <= 0) continue;

                $take = min($needed, $available);
                $batchAllocs[] = ['batch_product_id' => $bp->id, 'qty' => $take];
                $needed -= $take;
            }

            if ($needed > 0) {
                throw ValidationException::withMessages([
                    'products' => ["Insufficient stock for product ID {$item->productId}."],
                ]);
            }

            $allocations[$item->productId] = $batchAllocs;
        }

        return $allocations;
    }
}

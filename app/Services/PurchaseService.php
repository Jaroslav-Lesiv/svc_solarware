<?php

namespace App\Services;

use App\DTO\PurchaseData;
use App\Models\Batch;
use App\Models\Category;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PurchaseService
{
    public function purchase(PurchaseData $data): Batch
    {
        return DB::transaction(function () use ($data) {
            $provider = Provider::with('rootCategory')->findOrFail($data->providerId);
            $rootCategory = $provider->rootCategory;

            $productIds = array_map(fn($p) => $p->productId, $data->products);

            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            $validCategoryIds = $this->categoryDescendantIds($rootCategory->id);

            foreach ($products as $product) {
                if (! in_array($product->category_id, $validCategoryIds)) {
                    throw ValidationException::withMessages([
                        'products' => ["{$product->name} does not belong to this provider's categories."],
                    ]);
                }
            }

            $batch = Batch::create([
                'provider_id' => $data->providerId,
                'storage_id' => $data->storageId,
                'purchased_at' => $data->purchasedAt ?? today()->toDateString(),
            ]);

            foreach ($data->products as $item) {
                $batch->batchProducts()->create([
                    'product_id' => $item->productId,
                    'qty' => $item->qty,
                    'unit_cost' => $item->unitCost,
                ]);
            }

            return $batch->load(['provider', 'storage', 'batchProducts.product']);
        });
    }

    private function categoryDescendantIds(int $rootId): array
    {
        $ids = [$rootId];
        $queue = [$rootId];

        // BFS — category trees can be arbitrarily deep
        // TODO: memoize — bulk orders with same provider re-run this query per product
        while ($queue) {
            $children = Category::whereIn('parent_id', $queue)->pluck('id')->all();
            $ids = array_merge($ids, $children);
            $queue = $children;
        }

        return $ids;
    }
}

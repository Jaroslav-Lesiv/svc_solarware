<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'client_id' => $this->client_id,
            'items'     => $this->items->map(fn ($item) => [
                'product_id'   => $item->batchProduct->product_id,
                'product_name' => $item->batchProduct->product->name,
                'batch_id'     => $item->batchProduct->batch_id,
                'qty'          => $item->qty,
                'unit_price'   => $item->unit_price,
            ]),
        ];
    }
}

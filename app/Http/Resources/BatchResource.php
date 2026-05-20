<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'provider'     => $this->provider->name,
            'storage'      => $this->storage->name,
            'purchased_at' => $this->purchased_at->toDateString(),
            'items'        => $this->batchProducts->map(fn ($bp) => [
                'product_id'   => $bp->product_id,
                'product_name' => $bp->product->name,
                'qty'          => $bp->qty,
                'unit_cost'    => $bp->unit_cost,
            ]),
        ];
    }
}

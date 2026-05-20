<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchProfitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'batch_id'     => $this->batch_id,
            'purchased_at' => $this->purchased_at,
            'provider'     => $this->provider,
            'net_revenue'  => sprintf('%.2f', $this->net_revenue),
            'net_cost'     => sprintf('%.2f', $this->net_cost),
            'profit'       => sprintf('%.2f', $this->profit),
        ];
    }
}

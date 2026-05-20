<?php

namespace App\Services;

use App\Models\ClientRefund;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ClientRefundService
{
    public function refund(Order $order, array $items): void
    {
        DB::transaction(function () use ($order, $items) {
            foreach ($items as $item) {
                $orderItem = $order->items()->find($item['order_item_id']);

                if (! $orderItem) {
                    throw ValidationException::withMessages([
                        'items' => ["Order item {$item['order_item_id']} does not belong to this order."],
                    ]);
                }

                if ($item['qty'] > ($orderItem->qty - $orderItem->refundedQty())) {
                    throw ValidationException::withMessages([
                        'items' => ["Cannot refund {$item['qty']} units for order item {$orderItem->id}."],
                    ]);
                }

                ClientRefund::create([
                    'order_item_id' => $orderItem->id,
                    'qty' => $item['qty'],
                    'refunded_at' => today()->toDateString(),
                ]);
            }
        });
    }
}

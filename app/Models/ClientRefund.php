<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientRefund extends Model
{
    use HasFactory;

    protected $fillable = ['order_item_id', 'qty', 'refunded_at'];

    protected $casts = [
        'refunded_at' => 'date',
    ];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }
}

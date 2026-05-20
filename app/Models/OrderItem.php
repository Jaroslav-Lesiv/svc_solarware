<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'batch_product_id', 'qty', 'unit_price'];

    protected $casts = [
        'unit_price' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function batchProduct(): BelongsTo
    {
        return $this->belongsTo(BatchProduct::class);
    }

    public function clientRefunds(): HasMany
    {
        return $this->hasMany(ClientRefund::class);
    }

    public function refundedQty(): int
    {
        return $this->clientRefunds()->sum('qty');
    }
}

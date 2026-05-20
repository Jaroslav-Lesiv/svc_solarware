<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BatchProduct extends Model
{
    use HasFactory;

    protected $fillable = ['batch_id', 'product_id', 'qty', 'unit_cost'];

    protected $casts = [
        'unit_cost' => 'decimal:2',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function providerRefunds(): HasMany
    {
        return $this->hasMany(ProviderRefund::class);
    }

    public function availableQty(): int
    {
        $sold = $this->orderItems()->sum('qty');
        $returned = ClientRefund::whereIn('order_item_id', $this->orderItems()->select('id'))->sum('qty');
        $refunded = $this->providerRefunds()->sum('qty');

        // client refunds restore stock into this batch, hence +returned
        return $this->qty - $sold - $refunded + $returned;
    }
}

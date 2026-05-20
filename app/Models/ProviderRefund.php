<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderRefund extends Model
{
    use HasFactory;

    protected $fillable = ['batch_product_id', 'qty', 'refunded_at'];

    protected $casts = [
        'refunded_at' => 'date',
    ];

    public function batchProduct(): BelongsTo
    {
        return $this->belongsTo(BatchProduct::class);
    }
}

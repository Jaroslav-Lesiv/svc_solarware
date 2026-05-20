<?php

namespace App\DTO;

readonly class PurchaseProductData
{
    public function __construct(
        public int    $productId,
        public int    $qty,
        public string $unitCost,
    ) {}
}

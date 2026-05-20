<?php

namespace App\DTO;

readonly class OrderProductData
{
    public function __construct(
        public int $productId,
        public int $qty,
    ) {}
}

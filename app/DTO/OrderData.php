<?php

namespace App\DTO;

readonly class OrderData
{
    /** @var OrderProductData[] */
    public array $products;

    public function __construct(
        public int $clientId,
        array $products,
    ) {
        $this->products = $products;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            clientId: $data['client_id'],
            products: array_map(
                fn($p) => new OrderProductData($p['id'], $p['qty']),
                $data['products']
            ),
        );
    }
}

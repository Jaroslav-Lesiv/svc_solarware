<?php

namespace App\DTO;

readonly class PurchaseData
{
    /** @var PurchaseProductData[] */
    public array $products;

    public function __construct(
        public int $providerId,
        public int $storageId,
        public ?string $purchasedAt,
        array $products,
    ) {
        $this->products = $products;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            providerId: $data['provider_id'],
            storageId: $data['storage_id'],
            purchasedAt: $data['purchased_at'] ?? null,
            products: array_map(
                fn($p) => new PurchaseProductData($p['id'], $p['qty'], $p['unit_cost']),
                $data['products']
            ),
        );
    }
}

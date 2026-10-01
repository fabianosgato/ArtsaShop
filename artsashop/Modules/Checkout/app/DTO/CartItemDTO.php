<?php

namespace Modules\Checkout\DTO;

class CartItemDTO
{
    public function __construct(
        public int $product_id,
        public float $price,
        public int $qty,
        public float $subtotal,
        public array $product
    ) {}

    public function subtotal(): float
    {
        return $this->price * $this->qty;
    }

}


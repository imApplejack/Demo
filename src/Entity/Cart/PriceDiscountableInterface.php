<?php

declare(strict_types=1);

namespace Eric\Entity\Cart;

interface PriceDiscountableInterface
{
    public function getOriginalPrice(): float;

    public function getDiscountPrice(): float;

    /**
     * @return Discount[]
     */
    public function getDiscounts(): array;

    public function hasDiscount(): bool;
}

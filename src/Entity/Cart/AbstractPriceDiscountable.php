<?php

declare(strict_types=1);

namespace Eric\Entity\Cart;

abstract class AbstractPriceDiscountable implements PriceDiscountableInterface
{
    /**
     * @var Discount[]
     */
    private $discounts = [];

    public function applyDiscount(Discount $discount): void
    {
        $this->discounts[] = $discount;
    }

    public function cleanDiscounts(): void
    {
        $this->discounts = [];
    }

    public function getDiscounts(): array
    {
        return $this->discounts;
    }

    public function hasDiscount(): bool
    {
        return count($this->discounts) > 0;
    }

    protected function calculDiscount($price): float
    {
        foreach ($this->discounts as $discount) {
            $price = $discount->discountedPrice($price);
        }

        return $price;
    }
}

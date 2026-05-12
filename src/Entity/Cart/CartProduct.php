<?php

declare(strict_types=1);

namespace Eric\Entity\Cart;

use Eric\Entity\Shop\Category;
use Eric\Entity\Shop\Product;

class CartProduct extends AbstractPriceDiscountable implements ProductInfoInterface
{
    public function __construct(private readonly Product $product) {}

    public function getOriginalPrice(): float
    {
        return $this->product->getPrice();
    }

    public function getDiscountPrice(): float
    {
        return $this->calculDiscount($this->getOriginalPrice());
    }

    public function getName(): string
    {
        return $this->product->getName();
    }

    public function getCategory(): Category
    {
        return $this->product->getCategory();
    }
}

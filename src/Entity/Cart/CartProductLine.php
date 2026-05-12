<?php

declare(strict_types=1);

namespace Eric\Entity\Cart;

use Eric\Entity\Shop\Category;
use Eric\Entity\Shop\Product;

class CartProductLine extends AbstractPriceDiscountable implements ProductInfoInterface
{
    private int $count = 0;

    private CartProduct $cartProduct;

    public function __construct(Product $product)
    {
        $this->cartProduct = new CartProduct($product);
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function incrProduct(int $count = 1): void
    {
        $this->count += $count;
    }

    public function getCartProduct(): CartProduct
    {
        return $this->cartProduct;
    }

    public function getOriginalPrice(): float
    {
        return $this->count * $this->cartProduct->getOriginalPrice();
    }

    public function getDiscountPrice(): float
    {
        return $this->calculDiscount($this->count * $this->cartProduct->getDiscountPrice());
    }

    public function cleanDiscounts(): void
    {
        parent::cleanDiscounts();
        $this->cartProduct->cleanDiscounts();
    }

    public function getName(): string
    {
        return $this->cartProduct->getName();
    }

    public function getCategory(): Category
    {
        return $this->cartProduct->getCategory();
    }
}

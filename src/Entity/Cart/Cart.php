<?php

declare(strict_types=1);

namespace Eric\Entity\Cart;

use Eric\Entity\Shop\Product;

class Cart extends AbstractPriceDiscountable
{
    /**
     * @var CartProductLine[]
     */
    private array $productLines = [];

    public function addProduct(Product $product): void
    {
        if (!$this->getProductLine($product)) {
            $this->productLines[$product->getName()] = new CartProductLine($product);
        }
        $this->productLines[$product->getName()]->incrProduct();
    }

    /**
     * @return CartProductLine[]
     */
    public function getProductsLines(): array
    {
        return $this->productLines;
    }

    public function getOriginalPrice(): float
    {
        $retour = 0;
        foreach ($this->productLines as $productLine) {
            $retour += $productLine->getOriginalPrice();
        }

        return $retour;
    }

    public function getDiscountPrice(): float
    {
        $retour = 0;
        foreach ($this->productLines as $productLine) {
            $retour += $productLine->getDiscountPrice();
        }

        return $this->calculDiscount($retour);
    }

    public function cleanDiscounts(): void
    {
        parent::cleanDiscounts();
        foreach ($this->productLines as $productLine) {
            $productLine->cleanDiscounts();
        }
    }

    private function getProductLine(Product $product): ?CartProductLine
    {
        foreach ($this->productLines as $key => $value) {
            if ($key == $product->getName()) {
                return $value;
            }
        }

        return null;
    }
}

<?php

declare(strict_types=1);

namespace Eric\Service\Impl;

use Eric\Entity\Shop\Category;
use Eric\Entity\Shop\Product;
use Eric\Service\ProductServiceInterface;

readonly class ProductServiceImpl implements ProductServiceInterface
{
    public function getProduct(int $i): Product
    {
        return match ($i) {
            0 => new Product('Clavier', Category::Device, 89.99),
            1 => new Product('Câble USB-C', Category::Accessory, 12.5),
            2 => new Product('Écran 27', Category::Screen, 349),
            default => throw new \Exception('unavailable product id:'.$i),
        };
    }
}

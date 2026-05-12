<?php

declare(strict_types=1);

namespace Eric\Entity\Shop;

readonly class Product
{
    public function __construct(public string $name, public Category $category, public float $price) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}

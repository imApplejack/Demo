<?php

declare(strict_types=1);

namespace Eric\Entity\Cart;

use Eric\Service\DiscountRule\Util\DiscountUtil;

readonly class Discount
{
    public function __construct(private string $name, private DiscountType $type, private float $value) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): DiscountType
    {
        return $this->type;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function discountedPrice(float $price): float
    {
        return DiscountUtil::applyDiscountToPrice($this, $price);
    }
}

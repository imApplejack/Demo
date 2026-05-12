<?php

declare(strict_types=1);

namespace Eric\Service\DiscountRule\Util;

use Eric\Entity\Cart\Discount;
use Eric\Entity\Cart\DiscountType;

class DiscountUtil
{
    public static function applyDiscountToPrice(Discount $discount, float $price): float
    {
        $retour = match ($discount->getType()) {
            DiscountType::ABSOLUTE => $price - $discount->getValue(),
            DiscountType::PERCENT => $price * (100 - $discount->getValue()) / 100,
            default => throw new \Exception('Undefined DiscountType definition'),
        };

        return max(0, $retour);
    }
}

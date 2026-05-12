<?php

declare(strict_types=1);

namespace Eric\Service\DiscountRule\Module;

use Eric\Entity\Cart\Cart;
use Eric\Entity\Cart\Discount;
use Eric\Entity\Cart\DiscountType;
use Eric\Service\DiscountRule\DiscountRule;

class RemiseVolume extends DiscountRule
{
    public function getPriority(): int
    {
        return 10;
    }

    public function applyRule(Cart $cart): Cart
    {
        foreach ($cart->getProductsLines() as $productLine) {
            if ($productLine->getCount() >= 3) {
                $productLine->getCartProduct()->applyDiscount(new Discount('Remise volume', DiscountType::ABSOLUTE, 5));
            }
        }

        return $cart;
    }
}

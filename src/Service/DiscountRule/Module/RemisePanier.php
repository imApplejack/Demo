<?php

declare(strict_types=1);

namespace Eric\Service\DiscountRule\Module;

use Eric\Entity\Cart\Cart;
use Eric\Entity\Cart\Discount;
use Eric\Entity\Cart\DiscountType;
use Eric\Service\DiscountRule\DiscountRule;

class RemisePanier extends DiscountRule
{
    public function getPriority(): int
    {
        return 1;
    }

    public function applyRule(Cart $cart): Cart
    {
        if ($cart->getDiscountPrice() > 400) {
            $cart->applyDiscount(new Discount('Remise Panier', DiscountType::PERCENT, 5));
        }

        return $cart;
    }
}

<?php

declare(strict_types=1);

namespace Eric\Service\DiscountRule;

use Eric\Entity\Cart\Cart;

interface CartDiscountRuleInterface
{
    public function applyRule(Cart $cart): Cart;
}

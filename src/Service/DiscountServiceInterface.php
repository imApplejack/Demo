<?php

declare(strict_types=1);

namespace Eric\Service;

use Eric\Entity\Cart\Cart;

interface DiscountServiceInterface
{
    public function applyDiscountRules(Cart $cart): Cart;
}

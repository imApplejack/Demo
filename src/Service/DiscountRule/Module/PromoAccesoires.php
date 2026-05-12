<?php

declare(strict_types=1);

namespace Eric\Service\DiscountRule\Module;

use Eric\Entity\Cart\Cart;
use Eric\Entity\Cart\Discount;
use Eric\Entity\Cart\DiscountType;
use Eric\Entity\Shop\Category;
use Eric\Service\DiscountRule\DiscountRule;

class PromoAccesoires extends DiscountRule
{
    public function getPriority(): int
    {
        return 20;
    }

    public function applyRule(Cart $cart): Cart
    {
        foreach ($cart->getProductsLines() as $productLine) {
            if (Category::Accessory == $productLine->getCategory()) {
                // l'ennoncé demande de mettre la promotion sur l'accessoire mais le modele permet de mettre sur le bloc ProductLine
                $productLine->getCartProduct()->applyDiscount(new Discount('Promo Accesoires', DiscountType::PERCENT, 10));
            }
        }

        return $cart;
    }
}

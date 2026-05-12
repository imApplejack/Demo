<?php

declare(strict_types=1);

namespace Eric\Service;

use Eric\Entity\Cart\Cart;
use Eric\Entity\Shop\Product;

interface CartServiceInterface
{
    public function initCart(): Cart;

    public function addProductToCart(Cart $cart, Product $product): Cart;
}

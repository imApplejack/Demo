<?php

declare(strict_types=1);

namespace Eric\Service\Impl;

use Eric\Entity\Cart\Cart;
use Eric\Entity\Shop\Product;
use Eric\Service\CartServiceInterface;
use Eric\Service\DiscountServiceInterface;

readonly class CartServiceImpl implements CartServiceInterface
{
    public function __construct(private DiscountServiceInterface $discountService) {}

    public function initCart(): Cart
    {
        return new Cart();
    }

    public function addProductToCart(Cart $cart, Product $product): Cart
    {
        $cart->addProduct($product);
        $this->discountService->applyDiscountRules($cart);

        return $cart;
    }
}

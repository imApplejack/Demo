<?php

declare(strict_types=1);

namespace Tests\Mock;

use Eric\Container;
use Eric\Entity\Cart\Cart;

class CartMock
{
    public static function getCart()
    {
        $container = new Container();
        $productService = $container->productService;

        $cart = new Cart();
        $cart->addProduct($productService->getProduct(0));
        $cart->addProduct($productService->getProduct(1));
        $cart->addProduct($productService->getProduct(1));
        $cart->addProduct($productService->getProduct(1));
        $cart->addProduct($productService->getProduct(2));

        return $cart;
    }
}

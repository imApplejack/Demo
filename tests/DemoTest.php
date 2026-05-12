<?php

declare(strict_types=1);

namespace Tests;

use Eric\Container;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class DemoTest extends TestCase
{
    private Container $container;

    public function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
    }

    public function testDemo(): void
    {
        $cartService = $this->container->cartService;
        $productService = $this->container->productService;

        $cart = $cartService->initCart();
        $cartService->addProductToCart($cart, $productService->getProduct(0));
        $cartService->addProductToCart($cart, $productService->getProduct(1));
        $cartService->addProductToCart($cart, $productService->getProduct(1));
        $cartService->addProductToCart($cart, $productService->getProduct(1));
        $cartService->addProductToCart($cart, $productService->getProduct(2));
        $this->assertEquals(434.853, $cart->getDiscountPrice());
        $this->assertIsString($this->container->twig->render(['cart' => $cart]));
    }
}

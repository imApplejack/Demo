<?php

declare(strict_types=1);

namespace Tests;

use Eric\Container;
use Eric\Entity\Cart\Cart;
use Eric\Service\DiscountServiceInterface;
use PHPUnit\Framework\TestCase;
use Tests\Mock\CartMock;

/**
 * @internal
 */
class DiscountTest extends TestCase
{
    private DiscountServiceInterface $discountService;

    protected function setUp(): void
    {
        parent::setUp();
        $container = new Container();
        $this->discountService = $container->discountService;
    }

    public function testDiscount(): void
    {
        $cart = CartMock::getCart();

        $this->assertInstanceOf(Cart::class, $cart);

        $cart = $this->discountService->applyDiscountRules($cart);

        $this->assertCount(1, $cart->getDiscounts());
        $this->assertCount(2, $cart->getProductsLines()['Câble USB-C']->getCartProduct()->getDiscounts());
        $this->assertEquals(434.853, $cart->getDiscountPrice());
    }
}

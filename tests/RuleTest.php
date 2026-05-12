<?php

declare(strict_types=1);

namespace Tests;

use Eric\Container;
use Eric\Entity\Cart\Cart;
use Eric\Entity\Cart\Discount;
use Eric\Entity\Cart\DiscountType;
use Eric\Service\ProductServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class RuleTest extends TestCase
{
    private ProductServiceInterface $productService;

    private Cart $cart;

    protected function setUp(): void
    {
        parent::setUp();

        $container = new Container();
        $this->productService = $container->productService;

        $cart = new Cart();
        $cart->addProduct($this->productService->getProduct(0));
        $cart->addProduct($this->productService->getProduct(1));
        $cart->addProduct($this->productService->getProduct(2));
        $cart->addProduct($this->productService->getProduct(0));
        $cart->addProduct($this->productService->getProduct(0));
        $this->assertCount(3, $cart->getProductsLines());
        $this->cart = $cart;
    }

    public function testDiscount(): void
    {
        $discount = new Discount('test', DiscountType::ABSOLUTE, 10);
        $this->assertEquals(90, $discount->discountedPrice(100));

        $discount = new Discount('test', DiscountType::PERCENT, 10);
        $this->assertEquals(180, $discount->discountedPrice(200));

        $discount = new Discount('test', DiscountType::ABSOLUTE, 10000);
        $this->assertEquals(0, $discount->discountedPrice(200));
    }

    public function testDiscountProduct(): void
    {
        $this->assertEquals(89.99, $this->cart->getProductsLines()['Clavier']->getCartProduct()->getDiscountPrice());
        $this->assertEquals(631.47, $this->cart->getDiscountPrice());

        $this->cart->getProductsLines()['Clavier']->getCartProduct()->applyDiscount(new Discount('test', DiscountType::ABSOLUTE, 10));
        $this->assertEquals(79.99, $this->cart->getProductsLines()['Clavier']->getCartProduct()->getDiscountPrice());

        // clean
        $this->cart->cleanDiscounts();
        $this->assertEquals(89.99, $this->cart->getProductsLines()['Clavier']->getCartProduct()->getDiscountPrice());

        // percent
        $this->cart->getProductsLines()['Clavier']->getCartProduct()->applyDiscount(new Discount('test', DiscountType::PERCENT, 10));
        $this->assertEquals(80.991, $this->cart->getProductsLines()['Clavier']->getCartProduct()->getDiscountPrice());

        // double
        $this->cart->cleanDiscounts();
        $this->cart->getProductsLines()['Clavier']->getCartProduct()->applyDiscount(new Discount('test', DiscountType::ABSOLUTE, 10));
        $this->cart->getProductsLines()['Clavier']->getCartProduct()->applyDiscount(new Discount('test', DiscountType::PERCENT, 10));
        $this->assertEquals(71.991, $this->cart->getProductsLines()['Clavier']->getCartProduct()->getDiscountPrice());

        // transitivité
        $this->cart->cleanDiscounts();
        $this->cart->getProductsLines()['Clavier']->getCartProduct()->applyDiscount(new Discount('test', DiscountType::PERCENT, 10));
        $this->cart->getProductsLines()['Clavier']->getCartProduct()->applyDiscount(new Discount('test', DiscountType::ABSOLUTE, 10));
        $this->assertEquals(70.991, $this->cart->getProductsLines()['Clavier']->getCartProduct()->getDiscountPrice());

        // cart
        $this->cart->cleanDiscounts();
        $this->assertEquals(631.47, $this->cart->getDiscountPrice());
        $this->cart->applyDiscount(new Discount('test', DiscountType::ABSOLUTE, 10));
        $this->assertEquals(621.47, $this->cart->getDiscountPrice());

        // cart + product
        $this->cart->cleanDiscounts();
        $this->cart->getProductsLines()['Clavier']->getCartProduct()->applyDiscount(new Discount('test', DiscountType::ABSOLUTE, 10));
        $this->assertEquals(601.47, $this->cart->getDiscountPrice());

        // cart + product 2
        $this->cart->cleanDiscounts();
        $this->cart->getProductsLines()['Clavier']->getCartProduct()->applyDiscount(new Discount('test', DiscountType::ABSOLUTE, 10));
        $this->cart->applyDiscount(new Discount('test', DiscountType::ABSOLUTE, 10));
        $this->assertEquals(591.47, $this->cart->getDiscountPrice());

        // claviers gratuits
        $this->cart->cleanDiscounts();
        $this->cart->getProductsLines()['Clavier']->getCartProduct()->applyDiscount(new Discount('test', DiscountType::ABSOLUTE, 10000));
        $this->assertEquals(361.5, $this->cart->getDiscountPrice());

        $this->cart->cleanDiscounts();
        $this->cart->getProductsLines()['Clavier']->applyDiscount(new Discount('test', DiscountType::ABSOLUTE, 10000));
        $this->assertEquals(361.5, $this->cart->getDiscountPrice());

        $this->cart->cleanDiscounts();
        $this->cart->getProductsLines()['Clavier']->applyDiscount(new Discount('test', DiscountType::PERCENT, 100));
        $this->assertEquals(361.5, $this->cart->getDiscountPrice());
    }
}

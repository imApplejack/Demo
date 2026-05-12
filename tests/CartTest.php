<?php

declare(strict_types=1);

namespace Tests;

use Eric\Container;
use Eric\Entity\Cart\Cart;
use Eric\Entity\Shop\Product;
use Eric\Service\Impl\ProductServiceImpl;
use Eric\Service\ProductServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class CartTest extends TestCase
{
    private ProductServiceInterface $productService;

    protected function setUp(): void
    {
        parent::setUp();
        $container = new Container();
        $this->productService = $container->productService;
    }

    public function testGetproduct(): void
    {
        $this->assertInstanceOf(Product::class, (new ProductServiceImpl())->getProduct(0));
    }

    public function testHydrateCart(): void
    {
        $cart = new Cart();
        $cart->addProduct($this->productService->getProduct(0));
        $cart->addProduct($this->productService->getProduct(1));
        $cart->addProduct($this->productService->getProduct(2));
        $cart->addProduct($this->productService->getProduct(0));
        $cart->addProduct($this->productService->getProduct(0));
        $this->assertCount(3, $cart->getProductsLines());

        $this->assertEquals(631.47, $cart->getOriginalPrice());
    }
}

<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Eric\Container;
use Eric\Service\CartServiceInterface;
use Eric\Service\ProductServiceInterface;
use Twig\TemplateWrapper;

readonly class Demo
{
    private CartServiceInterface $cartService;

    private ProductServiceInterface $productService;

    private TemplateWrapper $twig;

    public function __construct(private Container $container)
    {
        $this->cartService = $container->cartService;
        $this->productService = $container->productService;
        $this->twig = $this->container->twig;
    }

    public function Run(): string
    {
        $cart = $this->cartService->initCart();
        $this->cartService->addProductToCart($cart, $this->productService->getProduct(0));
        $this->cartService->addProductToCart($cart, $this->productService->getProduct(1));
        $this->cartService->addProductToCart($cart, $this->productService->getProduct(1));
        $this->cartService->addProductToCart($cart, $this->productService->getProduct(1));
        $this->cartService->addProductToCart($cart, $this->productService->getProduct(2));

        return $this->twig->render(['cart' => $cart]);
    }
}

$demo = new Demo(new Container());
echo $demo->Run();

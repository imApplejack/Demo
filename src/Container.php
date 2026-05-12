<?php

declare(strict_types=1);

namespace Eric;

use Eric\Service\CartServiceInterface;
use Eric\Service\DiscountRule\Module\PromoAccesoires;
use Eric\Service\DiscountRule\Module\RemisePanier;
use Eric\Service\DiscountRule\Module\RemiseVolume;
use Eric\Service\DiscountServiceInterface;
use Eric\Service\Impl\CartServiceImpl;
use Eric\Service\Impl\DiscountServiceImpl;
use Eric\Service\Impl\ProductServiceImpl;
use Eric\Service\ProductServiceInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TemplateWrapper;

class Container
{
    public ProductServiceInterface $productService;

    public DiscountServiceInterface $discountService;

    public CartServiceInterface $cartService;

    public TemplateWrapper $twig;

    public function __construct()
    {
        /**
         * ici j'enregistre mes RG.
         * Avec un symfony j'aurais taggé les service avec des annotations et/ou un autowire dans service.yml et une pass de compilation.
         * Dans le meilleur des mondes ceux-ci viennent d'une repository de Promorule avec une configuration depuis un backoffice.
         */
        $discountService = new DiscountServiceImpl();
        $discountService->registerDiscountRule(new PromoAccesoires());
        $discountService->registerDiscountRule(new RemisePanier());
        $discountService->registerDiscountRule(new RemiseVolume());

        $this->discountService = $discountService;
        $this->productService = new ProductServiceImpl();
        $this->cartService = new CartServiceImpl($discountService);

        $loaderTwig = new FilesystemLoader('twig', __DIR__);
        $environnement = new Environment($loaderTwig);
        $this->twig = $environnement->load('cart.cli.twig');
    }
}

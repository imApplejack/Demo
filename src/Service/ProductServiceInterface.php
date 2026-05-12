<?php

declare(strict_types=1);

namespace Eric\Service;

use Eric\Entity\Shop\Product;

interface ProductServiceInterface
{
    public function getProduct(int $i): Product;
}

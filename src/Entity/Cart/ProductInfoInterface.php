<?php

declare(strict_types=1);

namespace Eric\Entity\Cart;

use Eric\Entity\Shop\Category;

interface ProductInfoInterface
{
    public function getName(): string;

    public function getCategory(): Category;
}

<?php

declare(strict_types=1);

namespace Eric\Entity\Cart;

enum DiscountType: string
{
    case PERCENT = 'percent';
    case ABSOLUTE = 'absolute';
}

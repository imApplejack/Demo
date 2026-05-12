<?php

declare(strict_types=1);

namespace Eric\Entity\Shop;

enum Category: string
{
    case Device = 'Device';
    case Accessory = 'Accessory';
    case Screen = 'Screen';
}

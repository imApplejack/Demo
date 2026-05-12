<?php

declare(strict_types=1);

namespace Eric\Service\DiscountRule;

interface DiscountRuleInterface
{
    public function getPriority(): int;
}

<?php

declare(strict_types=1);

namespace Eric\Service\Impl;

use Eric\Entity\Cart\Cart;
use Eric\Service\DiscountRule\DiscountRule;
use Eric\Service\DiscountServiceInterface;

class DiscountServiceImpl implements DiscountServiceInterface
{
    /**
     * @var DiscountRule[][]
     */
    private array $rules = [];

    public function registerDiscountRule(DiscountRule $rule): void
    {
        $this->rules[$rule->getPriority()][] = $rule;
        krsort($this->rules);
    }

    public function applyDiscountRules(Cart $cart): Cart
    {
        $cart->cleanDiscounts();
        foreach ($this->rules as $priorityRule) {
            foreach ($priorityRule as $rule) {
                $rule->applyRule($cart);
            }
        }

        return $cart;
    }
}

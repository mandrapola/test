<?php

class OverSumDiscount implements DiscountInterface
{
    const OVER_SUM = 10000;
    const DISCOUNT = 500;

    /**
     * @param Cart $cart
     *
     * @return bool
     */
    public static function isDiscount(Cart $cart): bool
    {
        return self::OVER_SUM < $cart->getTotalAmount();
    }

    /**
     * @param Cart $cart
     *
     * @return float
     */
    public static function getDiscount(Cart $cart): float
    {
        return self::DISCOUNT;
    }
}
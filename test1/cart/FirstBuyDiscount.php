<?php

class FirstBuyDiscount implements DiscountInterface
{
    const DISCOUNT = 100;

    /**
     * @param Cart $cart
     *
     * @return bool
     */
    public static function isDiscount(Cart $cart):bool
    {
        return 0 === $cart->getUser()->getOrdersCount();
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
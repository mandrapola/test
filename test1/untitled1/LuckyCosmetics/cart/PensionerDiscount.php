<?php

class PensionerDiscount implements DiscountInterface
{
    const PENSIONER_MALE_AGE = 65;
    const PENSIONER_FEMALE_AGE = 55;
    const DISCOUNT = 0.05;

    /**
     * @param Cart $cart
     *
     * @return bool
     */
    public static function isDiscount(Cart $cart): bool
    {
        return
            (self::PENSIONER_MALE_AGE <= $cart->getUser()->getAge()
                &&
                User::SEX_MALE === $cart->getUser()->getSex())
            ||
            (self::PENSIONER_FEMALE_AGE <= $cart->getUser()->getAge()
                &&
                User::SEX_FEMALE === $cart->getUser()->getSex());
    }

    /**
     * @param Cart $cart
     *
     * @return float
     */
    public static function getDiscount(Cart $cart): float
    {
        return $cart->getTotalAmount() * self::DISCOUNT;
    }
}
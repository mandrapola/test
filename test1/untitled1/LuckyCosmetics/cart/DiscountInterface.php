<?php

interface DiscountInterface
{
    public static function getDiscount(Cart $cart):float;
    public static function isDiscount(Cart $cart):bool;
}
<?php

class User
{
    const SEX_FEMALE = 0;
    const SEX_MALE = 1;

    /**
     * @return int
     */
    public function getAge(): int
    {
        return mt_rand(15, 80);
    }

    public function getOrdersCount(): int
    {
        return mt_rand(0, 5);
    }

    public function getSex(): int
    {
        return array_rand([self::SEX_FEMALE, self::SEX_MALE]);
    }
}

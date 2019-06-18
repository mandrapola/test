<?php

class Klad
{
    const MIN_M = 1;
    const MAX_M = 100;
    const MIN_COST = 0;
    const MAX_COST = 1000;
    const TYPE_STONE_ALMAZ = 'almaz';
    const TYPE_STONE_IZUMRUD = 'izumrud';
    private $stones;

    public function __construct($countStones)
    {
        $this->generateStones($countStones);
    }

    /**
     * @param int $countStones
     */
    private function generateStones(int $countStones)
    {
        for ($i = 1; $i <= $countStones; $i++) {
            $this->stones[] = $this->generateStone();
        }
        $this->sortByPrice();
    }

    /**
     * @return array
     * @throws Exception
     */
    private function generateStone(): array
    {
        return [
            'type' => array_rand([self::TYPE_STONE_ALMAZ, self::TYPE_STONE_IZUMRUD]),
            'm' => random_int(self::MIN_M, self::MAX_M),
            'cost' => random_int(self::MIN_COST, self::MAX_COST),
        ];
    }

    private function sortByPrice()
    {
        usort(
            $this->stones,
            function ($a, $b) {
                $aPrice = $a['cost'] / $a['m'];
                $bPrice = $b['cost'] / $b['m'];

                return $aPrice <=> $bPrice;
            }
        );
    }

    /**
     * @param bool $anyType
     *
     * @return array
     */
    public function findStones(bool $anyType = true): array
    {
        $stones = [];
        $m = 0;
        foreach ($this->stones as $stone) {
            if ($m + $stone['m'] <= self::MAX_M) {
                if (!array_key_exists($stone['type'], $stones) || $anyType) {
                    $stones[$stone['type']][] = $stone;
                    $m += $stone['m'];
                }
            }
        }

        return $stones;
    }
}
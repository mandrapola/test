<?php

class StoneManager
{
    /** @var array */
    private $stones;

    /** @var array */
    private $lastDiv;

    /**
     * stoneManager constructor.
     *
     * @param int $countStones
     */
    public function __construct($countStones)
    {
        $this->stones = [$countStones];
    }

    public function addBug()
    {
        $this->dividerStones();
        $this->applyStones();
    }

    private function dividerStones()
    {
        $maxStones = max($this->stones);
        $address = array_search($maxStones, $this->stones);
        $isRight = $address > intdiv(count($this->stones), 2);
        $left = intdiv($maxStones, 2);
        $right = $maxStones - $left;
        if ($right === $left) {
            if ($isRight) {
                $left--;
            } else {
                $right--;
            }
        } else {
            if ($right > $left) {
                $right--;
            } else {
                $left--;
            }
        }

        $this->setLastDiv(
            [
                'address' => $address,
                'left' => $left,
                'right' => $right,
            ]
        );
    }

    private function applyStones()
    {
        array_splice(
            $this->stones,
            $this->lastDiv['address'],
            1,
            [
                $this->lastDiv['left'],
                $this->lastDiv['right'],
            ]
        );
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return "{$this->getLastDiv()['left']};{$this->getLastDiv()['right']}\n";
    }

    /**
     * @return mixed
     */
    public function getLastDiv()
    {
        return $this->lastDiv;
    }

    /**
     * @param mixed $lastDiv
     */
    public function setLastDiv($lastDiv)
    {
        $this->lastDiv = $lastDiv;
    }
}

$arg = getopt('', ['stones:', 'bugs:']);
$countStones = $arg['stones'] ?? null;
$countBugs = $arg['bugs'] ?? null;
if (null === $countStones) {
    echo "Stones is null\n";
    exit;
}
if (null === $countBugs) {
    echo "Bugs is null\n";
    exit;
}
$stoneManager = new StoneManager($countStones);
foreach (range(1, $countBugs) as $bug) {
    $stoneManager->addBug();
}
echo $stoneManager->getResult();

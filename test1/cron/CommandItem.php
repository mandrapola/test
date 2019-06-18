<?php


class CommandItem
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $period;
    /**
     * @var DateTime
     */
    private $lastRunTime;
    /**
     * @var string
     */
    private $commandLine;
    /**
     * @var string[]
     */
    private $roles;

    public function __construct( array $commandData)
    {
        $this->name = $commandData['name'];
        $this->commandLine = $commandData['commandLine'];
        $this->roles = $commandData['roles'];
        $this->period = $commandData['period'] ?? 'P1D';
        if (isset($commandData['lastRunTime']['date'])) {
            $this->lastRunTime = new DateTime($commandData['lastRunTime']['date']);
        } else {
            $this->lastRunTime = new DateTime('yesterday');
        }
    }

    public function isLock(): bool
    {
        return $this->getStartTime()->getTimestamp() < $this->lastRunTime->getTimestamp();
    }

    private function getStartTime()
    {
        $startTime = new DateTime();
        $diff = new DateInterval($this->period);
        $startTime->sub($diff);

        return $startTime;
    }

    public function getData()
    {
        return [
            'name' => $this->name,
            'commandLine' => $this->commandLine,
            'period' => $this->period,
            'roles' => $this->roles,
            'lastRunTime' => $this->lastRunTime,
            'startTime' => $this->getStartTime(),
        ];
    }

    public function __toString()
    {
        return json_encode($this->getData());
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }


    public function lock()
    {
        $this->lastRunTime = new DateTime();
    }
}
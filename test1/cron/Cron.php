<?php

require_once 'CommandItem.php';
require_once 'Node.php';
require_once 'FileStorageProvider.php';

class Cron
{
    const PATH_CONFIG = __DIR__.'/config/cron.json';
    /**
     * @var array
     */
    private $request;
    /**
     * @var array
     */
    private $server;
    /**
     * @var array
     */
    private $nodes;
    /**
     * @var StorageProviderInterface
     */
    private $storageProvider;
    /**
     * @var CommandItem[]
     */
    private $commands;

    /**
     * Cron constructor.
     */
    public function __construct()
    {
        $this->request = $_REQUEST;
        $this->server = $_SERVER;
        $this->storageProvider = new FileStorageProvider();
    }

    public function run()
    {
        try {
            foreach ($this->getCommands() as $command) {
                if (!$command->isLock() && $this->access($command)) {
                    $command->lock();
                    $this->saveToFile();
                    $this->response(
                        [
                            'result' => [
                                'status' => 'ok',
                                'command' => $command->getData(),
                            ],
                        ]
                    );
                }
            }
            $this->response(
                [
                    'result' =>
                        [
                            'status' => 'lock',
                        ],
                ]
            );
        } catch (Exception $e) {
            $this->response($e->getMessage());
        }
    }

    /**
     * @return CommandItem[]
     */
    private function getCommands(): array
    {
        if (null === $this->commands) {
            $this->loadCommands();
        }

        return $this->commands;
    }

    private function loadCommands()
    {
        $data = $this->storageProvider->getData();
        foreach ($data as $commandData) {
            $this->commands[] = new CommandItem($commandData);
        }
    }

    /**
     * @param CommandItem $command
     *
     * @return bool
     */
    private function access(CommandItem $command)
    {
        $node = $this->getNodeByToken();

        return ($node instanceof Node && 0 < count(array_intersect($command->getRoles(), $node->getRoles())));
    }

    /**
     * @return Node|null
     */
    private function getNodeByToken()
    {
        foreach ($this->getNodes() as $node) {
            if ($this->server['HTTP_TOKEN'] ?? null === $node->getToken()) {
                return $node;
            }
        }

        return null;
    }

    /**
     * @return Node[]
     */
    private function getNodes(): array
    {
        if (null === $this->nodes) {
            $configNodes = include __DIR__.'/config/node.php';
            foreach ($configNodes as $node) {
                $this->nodes[] = new Node($node);
            }
        }

        return $this->nodes;
    }

    public function saveToFile()
    {
        $this->storageProvider->storeData($this->getCommandsData());
    }

    /**
     * @return array
     */
    private function getCommandsData()
    {
        return array_map(
            function (CommandItem $command) {
                return $command->getData();
            },
            $this->getCommands()
        );
    }

    public function response($response)
    {
        exit (json_encode($response));
    }
}
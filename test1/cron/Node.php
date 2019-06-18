<?php


class Node
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $roles;
    /**
     * @var string
     */
    private $token;

    /**
     * Node constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->roles = $data['roles'];
        $this->token = $data['token'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

}
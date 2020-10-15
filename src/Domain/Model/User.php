<?php


namespace App\Domain\Model;


class User
{
    private $id;
    private $name;
    private $email;

    /**
     * @param string $id
     * @param string $name
     * @param string $email
     */
    public function __construct(
        string $id,
        string $name,
        string $email
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function updateName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
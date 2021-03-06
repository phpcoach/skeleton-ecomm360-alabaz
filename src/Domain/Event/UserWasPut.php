<?php


namespace App\Domain\Event;

/**
 * Class UserWasPut
 */
class UserWasPut
{
    private $id;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->id;
    }
}
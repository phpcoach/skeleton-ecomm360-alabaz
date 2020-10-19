<?php


namespace App\Domain\Model;

use App\Domain\Exception\NotFoundException;
use React\Promise\PromiseInterface;

/**
 * Interface UserRepository
 */
interface UserRepository
{
    /**
     * @param string $id
     *
     * @return PromiseInterface<User, NotFoundException>
     */
    public function getUser(string $id) : PromiseInterface;

    /**
     * @param User $user
     *
     * @return PromiseInterface<void>
     */
    public function putUser(User $user) : PromiseInterface;

    /**
     * @param string $id
     *
     * @return PromiseInterface<void, NotFoundException>
     */
    public function deleteUser(string $id) : PromiseInterface;
}

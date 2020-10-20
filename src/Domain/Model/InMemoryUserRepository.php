<?php


namespace App\Domain\Model;


use App\Domain\Exception\NotFoundException;
use React\Promise\PromiseInterface;
use function React\Promise\reject;
use function React\Promise\resolve;

/**
 * Class InMemoryUserRepository
 */
class InMemoryUserRepository implements UserRepository
{
    private $users = [];

    /**
     * @param string $id
     *
     * @return PromiseInterface
     */
    public function getUser(string $id): PromiseInterface
    {
        if (array_key_exists($id, $this->users)) {
            return resolve($this->users[$id]);
        }

        return reject(new NotFoundException());
    }

    /**
     * @param User $user
     *
     * @return PromiseInterface
     */
    public function putUser(User $user): PromiseInterface
    {
        $this->users[$user->getId()] = $user;

        return resolve();
    }

    /**
     * @param string $id
     *
     * @return PromiseInterface
     */
    public function deleteUser(string $id): PromiseInterface
    {
        if (array_key_exists($id, $this->users)) {
            unset($this->users[$id]);

            return resolve();
        }

        return reject(new NotFoundException());
    }
}
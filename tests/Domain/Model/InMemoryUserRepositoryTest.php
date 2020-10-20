<?php


namespace Test\Domain\Model;


use App\Domain\Model\InMemoryUserRepository;
use App\Domain\Model\UserRepository;
use React\EventLoop\LoopInterface;

/**
 * Class InMemoryUserRepositoryTest
 */
class InMemoryUserRepositoryTest extends UserRepositoryTest
{
    /**
     * @param LoopInterface $loop
     *
     * @return UserRepository
     */
    public function createEmptyUserRepository(LoopInterface $loop): UserRepository
    {
        return new InMemoryUserRepository();
    }
}
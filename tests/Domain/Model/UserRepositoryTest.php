<?php


namespace Test\Domain\Model;

use App\Domain\Exception\NotFoundException;
use App\Domain\Model\User;
use App\Domain\Model\UserRepository;
use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use function Clue\React\Block\await;

/**
 * Class UserRepositoryTest
 */
abstract class UserRepositoryTest extends TestCase
{
    /**
     * @param LoopInterface $loop
     *
     * @return UserRepository
     */
    abstract public function createEmptyUserRepository(LoopInterface $loop) : UserRepository;


    public function testGetUserOnEmptyRepository()
    {
        $loop = Factory::create();
        $repository = $this->createEmptyUserRepository($loop);
        $promise = $repository->getUser('123');

        $this->expectException(NotFoundException::class);
        await($promise, $loop);
    }

    public function testGetUserExists()
    {
        $loop = Factory::create();
        $repository = $this->createEmptyUserRepository($loop);
        $promise = $repository->putUser(new User('123', 'Engonga', 'engonga@olakease.com'));
        await($promise, $loop);

        $promise = $repository->getUser('123');
        $user = await($promise, $loop);
        $this->assertEquals('123', $user->getId());
        $this->assertEquals('Engonga', $user->getName());
    }

    public function testUpdates()
    {
        $loop = Factory::create();
        $repository = $this->createEmptyUserRepository($loop);
        $promise = $repository->putUser(new User('123', 'Engonga', 'engonga@olakease.com'));
        await($promise, $loop);

        $promise = $repository->putUser(new User('123', 'Holi', 'engonga@olakease.com'));
        await($promise, $loop);

        $promise = $repository->getUser('123');
        $user = await($promise, $loop);
        $this->assertEquals('123', $user->getId());
        $this->assertEquals('Holi', $user->getName());
    }

    public function testDeleteUserWhenUserNotExists()
    {
        $loop = Factory::create();
        $repository = $this->createEmptyUserRepository($loop);
        $promise = $repository->deleteUser('123');

        $this->expectException(NotFoundException::class);
        await($promise, $loop);
    }

    public function testDeleteUser()
    {
        $loop = Factory::create();
        $repository = $this->createEmptyUserRepository($loop);
        $promise = $repository->putUser(new User('123', 'Engonga', 'engonga@olakease.com'));
        await($promise, $loop);

        $this->expectNotToPerformAssertions();
        $promise = $repository->deleteUser('123');
        await($promise, $loop);
    }
}
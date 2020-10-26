<?php


namespace Test\Infrastructure\DBAL\Model;


use App\Domain\Model\UserRepository;
use Infrastructure\DBAL\Model\DBALUserRepository;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Drift\DBAL\Connection;
use Drift\DBAL\Credentials;
use Drift\DBAL\Driver\SQLite\SQLiteDriver;
use React\EventLoop\LoopInterface;
use Test\Domain\Model\UserRepositoryTest;

/**
 * Class DBALUserRepositoryTest
 */
class DBALUserRepositoryTest extends UserRepositoryTest
{
    /**
     * @param LoopInterface $loop
     *
     * @return UserRepository
     */
    public function createEmptyUserRepository(LoopInterface $loop): UserRepository
    {
        $platform = new SqlitePlatform();
        $driver = new SQLiteDriver($loop);
        $credentials = new Credentials(
            '',
            '',
            'root',
            'root',
            ':memory:'
        );

        $connection = Connection::createConnected(
            $driver,
            $credentials,
            $platform
        );

        $connection->createTable('users', [
            'id' => 'string',
            'name' => 'string',
            'email' => 'string'
        ]);

        return new DBALUserRepository($connection);
    }
}
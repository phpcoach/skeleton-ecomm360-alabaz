<?php


namespace Infrastructure\DBAL\Model;


use App\Domain\Exception\NotFoundException;
use App\Domain\Model\User;
use App\Domain\Model\UserRepository;
use Drift\DBAL\Connection;
use Drift\DBAL\Result;
use React\Promise\PromiseInterface;

/**
 * Class DBALUserRepository
 */
class DBALUserRepository implements UserRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $id
     *
     * @return PromiseInterface<User, NotFoundException>
     */
    public function getUser(string $id) : PromiseInterface
    {
        return $this
            ->connection
            ->findOneBy('users',['id' => $id])
            ->then(function(?array $result){
                if (is_null($result)) {
                    throw new NotFoundException('Not found user');
                }
                return new User($result['id'],$result['name'],$result['email']);
            });
    }

    /**
     * @param User $user
     *
     * @return PromiseInterface<void>
     */
    public function putUser(User $user) : PromiseInterface
    {
        return $this
            ->connection
            ->upsert('users',['id' => $user->getId()],
                    ['name' => $user->getName(), 'email' => $user->getEmail()])
            ->then(function(){
            });
    }

    /**
     * @param string $id
     *
     * @return PromiseInterface<void, NotFoundException>
     */
    public function deleteUser(string $id) : PromiseInterface
    {
        return $this
            ->connection
            ->delete('users',['id' => $id])
            ->then(function(Result $result){
               if ($result->getAffectedRows() !== 1) {
                   throw new NotFoundException('not found');
               }
            });
    }
}
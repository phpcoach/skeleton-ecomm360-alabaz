<?php


namespace App\Domain\QueryHandler;

use App\Domain\Model\User;
use App\Domain\Model\UserRepository;
use App\Domain\Query\GetUser;
use React\Promise\PromiseInterface;

/**
 * Class GetUserHandler
 */
class GetUserHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param GetUser $getUser
     *
     * @return PromiseInterface<User>
     */
    public function handle(GetUser $getUser) : PromiseInterface
    {
        return $this
            ->userRepository
            ->getUser($getUser->getId());
    }
}
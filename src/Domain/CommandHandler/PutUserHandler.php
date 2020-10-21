<?php


namespace App\Domain\CommandHandler;

use App\Domain\Command\PutUser;
use App\Domain\Model\UserRepository;
use React\Promise\PromiseInterface;

/**
 * Class PutUserHandler
 */
class PutUserHandler
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
     * @param PutUser $putUser
     *
     * @return PromiseInterface<void>
     */
    public function handle(PutUser $putUser) : PromiseInterface
    {
        return $this
            ->userRepository
            ->putUser($putUser->getUser());
    }
}
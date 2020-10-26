<?php


namespace App\Domain\CommandHandler;

use App\Domain\Command\PutUser;
use App\Domain\Event\UserWasPut;
use App\Domain\Model\UserRepository;
use Drift\EventBus\Bus\EventBus;
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
     * @var EventBus
     */
    private $eventBus;

    /**
     * @param UserRepository $userRepository
     * @param EventBus       $eventBus
     */
    public function __construct(UserRepository $userRepository, EventBus $eventBus)
    {
        $this->userRepository = $userRepository;
        $this->eventBus = $eventBus;
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
            ->putUser($putUser->getUser())
            ->then(function() use ($putUser) {
                return $this
                    ->eventBus
                    ->dispatch(new UserWasPut($putUser->getUser()));
            });
    }
}
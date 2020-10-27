<?php


namespace App\Domain\CommandHandler;

use App\Domain\Command\DeleteUser;
use App\Domain\Event\UserWasDeleted;
use App\Domain\Event\UserWasPut;
use App\Domain\Model\UserRepository;
use Drift\EventBus\Bus\EventBus;
use React\Promise\PromiseInterface;

/**
 * Class DeletedUserHandler
 */
class DeletedUserHandler
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
     * @param DeleteUser $deleteUser
     *
     * @return PromiseInterface<void>
     */
    public function handle(DeleteUser $deleteUser) : PromiseInterface
    {
        return $this
            ->userRepository
            ->deleteUser($deleteUser->getId())
            ->then(function() use ($deleteUser) {
                return $this
                    ->eventBus
                    ->dispatch(new UserWasDeleted($deleteUser->getId()));
            });
    }
}
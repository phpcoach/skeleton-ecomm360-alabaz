<?php


namespace Infrastructure\DBAL\Model;

use App\Domain\Event\UserWasDeleted;
use App\Domain\Event\UserWasPut;
use App\Domain\Model\InMemoryUserRepository;
use App\Domain\Model\User;
use App\Domain\Model\UserRepository;
use Drift\HttpKernel\Event\DomainEventEnvelope;
use React\Promise\PromiseInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ComposedUserRepository
 */
class ComposedUserRepository implements UserRepository, EventSubscriberInterface
{
    private InMemoryUserRepository $inMemoryRepository;
    private DBALUserRepository $dbalUserRepository;

    /**
     * @param InMemoryUserRepository $inMemoryRepository
     * @param DBALUserRepository     $dbalUserRepository
     */
    public function __construct(
        InMemoryUserRepository $inMemoryRepository,
        DBALUserRepository $dbalUserRepository
    )
    {
        $this->inMemoryRepository = $inMemoryRepository;
        $this->dbalUserRepository = $dbalUserRepository;
    }

    /**
     * @param string $id
     *
     * @return PromiseInterface
     */
    public function getUser(string $id): PromiseInterface
    {
        return $this
            ->inMemoryRepository
            ->getUser($id);
    }

    /**
     * @param User $user
     *
     * @return PromiseInterface
     */
    public function putUser(User $user): PromiseInterface
    {
        return $this
            ->dbalUserRepository
            ->putUser($user);
    }

    /**
     * @param string $id
     *
     * @return PromiseInterface
     */
    public function deleteUser(string $id): PromiseInterface
    {
        return $this
            ->dbalUserRepository
            ->deleteUser($id);
    }

    /**
     * @param DomainEventEnvelope $domainEventEnvelope
     */
    public function loadUserIntoMemory(DomainEventEnvelope $domainEventEnvelope)
    {
        /**
         * @var UserWasPut $userWasPut
         */
        $userWasPut = $domainEventEnvelope->getDomainEvent();

        return $this
            ->dbalUserRepository
            ->getUser($userWasPut->getUserId())
            ->then(function(User $user) {
                return $this
                    ->inMemoryRepository
                    ->putUser($user);
            });
    }

    /**
     * @param DomainEventEnvelope $domainEventEnvelope
     */
    public function removeUserFromMemory(DomainEventEnvelope $domainEventEnvelope)
    {
        /**
         * @var UserWasDeleted $userWasDeleted
         */
        $userWasDeleted = $domainEventEnvelope->getDomainEvent();

        return $this
            ->inMemoryRepository
            ->deleteUser($userWasDeleted->getUserId());
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents() : array
    {
        return [
            UserWasPut::class => 'loadUserIntoMemory',
            UserWasDeleted::class => 'removeUserFromMemory',
        ];
    }
}
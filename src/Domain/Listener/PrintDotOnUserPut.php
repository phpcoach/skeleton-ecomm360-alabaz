<?php


namespace App\Domain\Listener;


use App\Domain\Event\UserWasPut;
use Drift\HttpKernel\Event\DomainEventEnvelope;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class PrintDotOnUserPut
 */
class PrintDotOnUserPut implements EventSubscriberInterface
{
    /**
     * @param DomainEventEnvelope $eventEnvelope
     */
    public function printDot(DomainEventEnvelope $eventEnvelope)
    {
        /**
         * @var UserWasPut $event
         */
        $event = $eventEnvelope->getDomainEvent();
        var_dump('User with id ' . $event->getUser()->getId() . ' was put');
    }

    /**
     * @return array|void
     */
    public static function getSubscribedEvents()
    {
        return [
            UserWasPut::class => 'printDot'
        ];
    }
}
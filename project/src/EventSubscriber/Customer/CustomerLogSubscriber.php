<?php

declare(strict_types=1);

namespace App\EventSubscriber\Customer;

use App\Entity\CustomerLog\CustomerLog;
use App\Event\Customer\CustomerCreatedEvent;
use App\Event\Customer\CustomerUpdatedEvent;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomerLogSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            CustomerCreatedEvent::class => 'onCustomerCreated',
            CustomerUpdatedEvent::class => 'onCustomerUpdated',
        ];
    }

    public function onCustomerCreated(CustomerCreatedEvent $event): void
    {
        $log = CustomerLog::createCreatedLog(
            $event->getCustomer(),
            new DateTimeImmutable()
        );

        $this->em->persist($log);
        $this->em->flush();
    }

    public function onCustomerUpdated(CustomerUpdatedEvent $event): void
    {
        $log = CustomerLog::createUpdatedLog(
            $event->getCustomer(),
            new DateTimeImmutable()
        );

        $this->em->persist($log);
        $this->em->flush();
    }
}

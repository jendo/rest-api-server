<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Utils\PrivatePropertyManipulator;
use App\Entity\Customer\Customer;
use App\Entity\CustomerLog\CustomerLog;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class CustomerFixtures extends Fixture
{
    public const FIRST_CUSTOMER_ID = '417f2eb6-a5e4-45dd-b99b-f24a80de287b';
    public const SECOND_CUSTOMER_ID = '41d93864-a93c-4ef6-a1b4-689cad970cd6';

    public function load(ObjectManager $manager): void
    {
        $customer1 = new Customer(
            'jan.novak@example.com',
            'Jan',
            'Novák'
        );

        PrivatePropertyManipulator::patchProperty(
            $customer1,
            Customer::getIdColumn(),
            Uuid::fromString(self::FIRST_CUSTOMER_ID)
        );

        $manager->persist($customer1);
        $manager->persist(
            CustomerLog::createCreatedLog(
                $customer1,
                new DateTimeImmutable()
            )
        );

        $customer2 = new Customer(
            'eva.kovacova@example.com',
            'Eva',
            'Kováčová'
        );

        PrivatePropertyManipulator::patchProperty(
            $customer2,
            Customer::getIdColumn(),
            Uuid::fromString(self::SECOND_CUSTOMER_ID)
        );

        $manager->persist($customer2);
        $manager->persist(
            CustomerLog::createCreatedLog(
                $customer2,
                new DateTimeImmutable()
            )
        );

        $manager->flush();
    }
}

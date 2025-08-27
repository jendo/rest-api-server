<?php

namespace App\DataFixtures;

use App\Entity\Customer\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $customer1 = new Customer(
            'jan.novak@example.com',
            'Jan',
            'Novák'
        );
        $manager->persist($customer1);

        $customer2 = new Customer(
            'eva.kovacova@example.com',
            'Eva',
            'Kováčová'
        );
        $manager->persist($customer2);

        $manager->flush();
    }
}

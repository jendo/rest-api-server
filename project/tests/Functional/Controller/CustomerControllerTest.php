<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\DataFixtures\CustomerFixtures;
use App\Entity\Customer\Customer;
use App\Repository\Customer\CustomerRepository;
use App\Tests\Functional\FunctionalTestCase;
use App\Utils\Json;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerControllerTest extends FunctionalTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    public function testCreate(): void
    {
        $email = 'john.doe@gmail.com';

        $customerRepository = $this->customerRepository();
        $existingCustomerWithSameEmail = $customerRepository->findOneBy([Customer::COLUMN_EMAIL => $email]);

        self::assertNull($existingCustomerWithSameEmail);

        $this->client->request(
            Request::METHOD_POST,
            '/api/customers',
            content: Json::encode(
                [
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'email' => 'john.doe@gmail.com',
                ]
            )
        );

        $response = self::jsonDecodeResponse($this->client);

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

    public function testUpdate(): void
    {
        $newFirstName = 'John';
        $newLastName = 'Doe';

        $customerRepository = $this->customerRepository();

        $existingCustomer = $customerRepository->find(CustomerFixtures::FIRST_CUSTOMER_ID);
        self::assertNotNull($existingCustomer);
        self::assertNotSame($newFirstName, $existingCustomer->getFirstName());
        self::assertNotSame($newLastName, $existingCustomer->getLastName());

        $this->client->request(
            Request::METHOD_PATCH,
            sprintf('/api/customers/%s', $existingCustomer->getId()),
            content: Json::encode(
                [
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                ]
            )
        );

        $response = self::jsonDecodeResponse($this->client);

        $this->entityManager()->refresh($existingCustomer);

        self::assertSame($newFirstName, $existingCustomer->getFirstName());
        self::assertSame($newLastName, $existingCustomer->getLastName());

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    protected function customerRepository(): CustomerRepository
    {
        /** @var CustomerRepository $customerRepository */
        $customerRepository = self::getContainer()->get(CustomerRepository::class);

        return $customerRepository;
    }

    protected function entityManager(): EntityManagerInterface
    {
        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get(EntityManagerInterface::class);

        return $em;
    }
}

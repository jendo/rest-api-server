<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Api\Response\ResponseFactory;
use App\DataFixtures\CustomerFixtures;
use App\Entity\Customer\Customer;
use App\Entity\CustomerLog\CustomerLogAction;
use App\Repository\Customer\CustomerRepository;
use App\Repository\CustomerLog\CustomerLogRepository;
use App\Tests\Functional\FunctionalTestCase;
use App\Utils\Json;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerControllerTest extends FunctionalTestCase
{
    private const URI = '/api/customers';

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    public function testCreate(): void
    {
        $email = 'john.doe@gmail.com';
        $customerRepository = $this->customerRepository();

        $customerWithSameEmail = $customerRepository->findOneBy([Customer::COLUMN_EMAIL => $email]);
        self::assertNull($customerWithSameEmail);

        $this->client->request(
            Request::METHOD_POST,
            self::URI,
            content: Json::encode(
                [
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'email' => $email,
                ]
            )
        );

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        self::assertRouteSame('customer_create');

        $response = self::jsonDecodeResponse($this->client);
        self::assertIsArray($response);
        self::assertArrayHasKey('status', $response);
        self::assertArrayHasKey('data', $response);
        self::assertSame('success', $response['status']);
        self::assertIsArray($response['data']);

        $responseData = $response['data'];
        self::assertArrayHasKey('id', $responseData);
        self::assertIsString($responseData['id']);
        self::assertArrayHasKey('firstName', $responseData);
        self::assertArrayHasKey('lastName', $responseData);
        self::assertArrayHasKey('email', $responseData);

        $createdCustomer = $customerRepository->find(Uuid::fromString($responseData['id']));
        self::assertNotNull($createdCustomer);
        self::assertSame($responseData['id'], $createdCustomer->getId()->toString());
        self::assertSame($responseData['firstName'], $createdCustomer->getFirstName());
        self::assertSame($responseData['lastName'], $createdCustomer->getLastName());
        self::assertSame($responseData['email'], $createdCustomer->getEmail());
    }

    public function testCreateWithExistingEmailThrowsException(): void
    {
        $email = 'jan.novak@example.com';
        $customerRepository = $this->customerRepository();

        $customerWithSameEmail = $customerRepository->findOneBy([Customer::COLUMN_EMAIL => $email]);
        self::assertNotNull($customerWithSameEmail);

        $this->client->request(
            Request::METHOD_POST,
            self::URI,
            content: Json::encode(
                [
                    'firstName' => 'Jan',
                    'lastName' => 'Novak',
                    'email' => $email,
                ]
            )
        );

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        self::assertRouteSame('customer_create');

        $response = self::jsonDecodeResponse($this->client);
        self::assertIsArray($response);
        self::assertArrayHasKey('status', $response);
        self::assertArrayHasKey('errors', $response);
        self::assertSame('error', $response['status']);
        self::assertCount(1, $response['errors']);
        self::assertSame('Email already exists.', $response['errors'][0][ResponseFactory::DATA_FIELD_MESSAGE]);
    }

    public function testUpdate(): void
    {
        $newFirstName = 'John';
        $newLastName = 'Doe';

        $existingCustomer = $this->customerRepository()->find(CustomerFixtures::FIRST_CUSTOMER_ID);
        self::assertNotNull($existingCustomer);
        self::assertNotSame($newFirstName, $existingCustomer->getFirstName());
        self::assertNotSame($newLastName, $existingCustomer->getLastName());

        $log = $this->customerLogRepository()->findOneBy(
            [
                'customer' => $existingCustomer,
                'action' => CustomerLogAction::CREATED()
            ]
        );
        self::assertNotNull($log);

        $this->client->request(
            Request::METHOD_PATCH,
            sprintf('%s/%s', self::URI, $existingCustomer->getId()),
            content: Json::encode(
                [
                    'firstName' => $newFirstName,
                    'lastName' => $newLastName,
                ]
            )
        );

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertRouteSame('customer_update');

        $response = self::jsonDecodeResponse($this->client);
        self::assertIsArray($response);
        self::assertArrayHasKey('status', $response);
        self::assertSame('success', $response['status']);

        $this->entityManager()->refresh($existingCustomer);
        self::assertSame($newFirstName, $existingCustomer->getFirstName());
        self::assertSame($newLastName, $existingCustomer->getLastName());
    }

    private function customerRepository(): CustomerRepository
    {
        /** @var CustomerRepository $customerRepository */
        $customerRepository = self::getContainer()->get(CustomerRepository::class);

        return $customerRepository;
    }

    private function customerLogRepository(): CustomerLogRepository
    {
        /** @var CustomerLogRepository $customerLogRepository */
        $customerLogRepository = self::getContainer()->get(CustomerLogRepository::class);

        return $customerLogRepository;
    }

    private function entityManager(): EntityManagerInterface
    {
        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get(EntityManagerInterface::class);

        return $em;
    }
}

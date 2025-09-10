<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Repository\Customer\CustomerRepository;
use App\Tests\Functional\FunctionalTestCase;
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

        $container = static::getContainer();
        $container->get(CustomerRepository::class);

        $customerRepository = $this->providedCustomerRepository();
        $existingCustomerWithSameEmail = $customerRepository->findOneByEmail($email);

        self::assertNull($existingCustomerWithSameEmail);

        $this->client->request(
            Request::METHOD_POST,
            '/api/customers',
            content: self::safeJsonEncode(
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

    protected function providedCustomerRepository(): CustomerRepository
    {
        return self::getContainer()->get(CustomerRepository::class);
    }
}

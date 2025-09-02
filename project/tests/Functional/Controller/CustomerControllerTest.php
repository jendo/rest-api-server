<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Entity\Customer\Customer;
use App\Repository\Customer\CustomerRepository;
use App\Tests\Functional\FunctionalTestCase;
use App\Utils\Json;
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

    protected function customerRepository(): CustomerRepository
    {
        /** @var CustomerRepository $customerRepository */
        $customerRepository = self::getContainer()->get(CustomerRepository::class);

        return $customerRepository;
    }
}

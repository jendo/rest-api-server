<?php

declare(strict_types=1);

namespace App\Controller;

use App\Api\Response\ResponseFactory;
use App\Entity\Customer\Customer;
use App\Entity\CustomerSettings\CustomerSettings;
use App\Request\Customer\CustomerCreateRequest;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CustomerController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route('/customers', name: 'customer_create', methods: [Request::METHOD_POST])]
    public function create(
        Request $request
    ): JsonResponse {
        /** @var CustomerCreateRequest $customerCreateRequest */
        $customerCreateRequest = $this->serializer->deserialize(
            $request->getContent(),
            CustomerCreateRequest::class,
            JsonEncoder::FORMAT
        );

        $errors = $this->validator->validate($customerCreateRequest);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = [
                    'property' => $error->getPropertyPath(),
                    ResponseFactory::DATA_FIELD_MESSAGE => (string) $error->getMessage(),
                ];
            }

            return ResponseFactory::error($errorMessages);
        }

        $customer = Customer::createFromRequest($customerCreateRequest);

        try {
            $this->em->wrapInTransaction(function () use ($customer) {
                $this->em->persist($customer);
                $this->em->persist(new CustomerSettings($customer, 'sk', true));

                $this->em->flush();
            });
        } catch (UniqueConstraintViolationException $e) {
            return ResponseFactory::error('Email already exists.');
        }

        return ResponseFactory::success(
            [
                'id' => $customer->getId()->toString(),
                'firstName' => $customer->getFirstName(),
                'lastName' => $customer->getLastName(),
                'email' => $customer->getEmail(),
            ],
            Response::HTTP_CREATED
        );
    }
}

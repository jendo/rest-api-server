<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Utils\Json;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalTestCase extends WebTestCase
{
    protected static function jsonDecodeResponse(KernelBrowser $client): mixed
    {
        return Json::decode($client->getResponse()->getContent());
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Utils\Json;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalTestCase extends WebTestCase
{
    protected static function jsonDecodeResponse(KernelBrowser $client): mixed
    {
        $content = $client->getResponse()->getContent();
        if ($content === false) {
            throw new RuntimeException('Response content is false!');
        }

        return Json::decode($content);
    }
}

<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerControllerTest extends WebTestCase
{
    public function testActualcourse()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/actualCourse');
    }

    public function testNextcourse()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/nextCourse');
    }

}

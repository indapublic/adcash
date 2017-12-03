<?php

declare(strict_types=1);

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testUsers()
    {
        $client = static::createClient();
        //  Redirect on GET `/api/users`
        $client->request('GET', '/api/users');
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
        //  HTTP 200 OK on GET `/api/users/`
        $client->request('GET', '/api/users/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
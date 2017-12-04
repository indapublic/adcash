<?php

declare(strict_types=1);

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserOrderControllerTest extends WebTestCase
{
    public function testOrders()
    {
        $client = static::createClient();
        //  Redirect on GET `/api/orders`
        $client->request('GET', '/api/orders');
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
        //  HTTP 200 OK on GET `/api/orders/`
        $client->request('GET', '/api/orders/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //  HTTP 404 Not Found on GET `/api/orders/NotExisting`
        $client->request('GET', '/api/orders/NotExisting');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        //  HTTP 400 Bad Request on empty POST `/api/orders/`
        $client->request('POST', '/api/orders/');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}
<?php

declare(strict_types=1);

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserOrderControllerTest extends WebTestCase
{
    public function testOrders()
    {
        $client = static::createClient();
        //  Redirect on GET `/api/orders`
        $client->request('GET', '/api/orders');
        $this->assertEquals(Response::HTTP_MOVED_PERMANENTLY, $client->getResponse()->getStatusCode());
        //  HTTP 200 OK on GET `/api/orders/`
        $client->request('GET', '/api/orders/');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        //  HTTP 404 Not Found on GET `/api/orders/NotExisting`
        $client->request('GET', '/api/orders/NotExisting');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
        //  HTTP 400 Bad Request on empty POST `/api/orders/`
        $client->request('POST', '/api/orders/');
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
}
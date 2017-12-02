<?php

declare(strict_types=1);

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserOrderControllerTest extends WebTestCase
{
    public function testRedirection()
    {
        $client = static::createClient();
        $client->request('GET', '/api/orders');
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
    }

    public function testGetOrders()
    {
        $client = static::createClient();
        $client->request('GET', '/api/orders/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = \GuzzleHttp\json_decode($client->getResponse()->getContent(), true);
        $this->assertNotCount(0, $data);
        $this->assertArrayHasKey('product', $data[0]);
    }

}
<?php

declare(strict_types=1);

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testProducts()
    {
        $client = static::createClient();
        //  Redirect on GET `/api/products`
        $client->request('GET', '/api/products');
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
        //  HTTP 200 OK on GET `/api/products/`
        $client->request('GET', '/api/products/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
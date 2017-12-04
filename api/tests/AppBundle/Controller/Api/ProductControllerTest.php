<?php

declare(strict_types=1);

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends WebTestCase
{
    public function testProducts()
    {
        $client = static::createClient();
        //  Redirect on GET `/api/products`
        $client->request('GET', '/api/products');
        $this->assertEquals(Response::HTTP_MOVED_PERMANENTLY, $client->getResponse()->getStatusCode());
        //  HTTP 200 OK on GET `/api/products/`
        $client->request('GET', '/api/products/');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

}
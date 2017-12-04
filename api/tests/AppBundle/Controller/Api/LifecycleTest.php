<?php

declare(strict_types=1);

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LifecycleTest extends WebTestCase
{
    public function testLifecycle()
    {
        $client = static::createClient();
        /**
         * Get products.
         */
        $client->request('GET', '/api/products/');
        $products = \GuzzleHttp\json_decode($client->getResponse()->getContent(), true);
        $this->assertNotCount(0, $products);
        $this->assertArrayHasKey('id', $products[0]);
        $productId = $products[0]['id'];
        /**
         * Get users.
         */
        $client->request('GET', '/api/users/');
        $users = \GuzzleHttp\json_decode($client->getResponse()->getContent(), true);
        $this->assertNotCount(0, $users);
        $this->assertArrayHasKey('id', $users[0]);
        $userId = $users[0]['id'];
        /**
         * Error on negative quantity.
         */
        $client->request('POST', '/api/orders/', array(
            'user-id' => $userId,
            'product-id' => $productId,
            'quantity' => -1
        ));
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        /**
         * Add new order.
         */
        $client->request('POST', '/api/orders/', array(
            'user-id' => $userId,
            'product-id' => $productId,
            'quantity' => 1
        ));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $addedOrder = \GuzzleHttp\json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $addedOrder);
        /**
         * Get existing order.
         */
        $client->request('GET', '/api/orders/' . $addedOrder['id']);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $existingOrder = \GuzzleHttp\json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $existingOrder);
        /**
         * Update existing order.
         */
        $client->request('PUT', '/api/orders/' . $existingOrder['id'], array(
            'user-id' => $userId,
            'product-id' => $productId,
            'quantity' => 99
        ));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        /**
         * Delete existing order.
         */
        $client->request('DELETE', '/api/orders/'. $existingOrder['id']);
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
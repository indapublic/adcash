<?php

declare(strict_types=1);

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DiscountTest extends WebTestCase
{
    public function testDiscount()
    {
        $client = static::createClient();
        /**
         * Get users.
         */
        $client->request('GET', '/api/users/');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $users = \GuzzleHttp\json_decode($client->getResponse()->getContent(), true);
        $this->assertNotCount(0, $users);
        /**
         * Get products.
         */
        $client->request('GET', '/api/products/');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $products = \GuzzleHttp\json_decode($client->getResponse()->getContent(), true);
        $this->assertNotCount(0, $products);
        $quantity = 3;
        foreach ($products as $product) {
            /**
             * Create order.
             */
            $client->request('POST', '/api/orders/', array(
                'user-id' => $users[0]['id'],
                'product-id' => $product['id'],
                'quantity' => $quantity
            ));
            $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
            $addedOrder = \GuzzleHttp\json_decode($client->getResponse()->getContent(), true);
            $this->assertArrayHasKey('id', $addedOrder);
            /**
             * Get order.
             */
            $client->request('GET', '/api/orders/' . $addedOrder['id']);
            $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
            $existingOrder = \GuzzleHttp\json_decode($client->getResponse()->getContent(), true);
            /**
             * Check all fields are exist.
             */
            $this->assertArrayHasKey('product', $existingOrder);
            $this->assertArrayHasKey('price', $existingOrder['product']);
            $this->assertArrayHasKey('discount', $existingOrder['product']);
            $this->assertArrayHasKey('price', $existingOrder);
            $this->assertArrayHasKey('quantity', $existingOrder);
            $this->assertArrayHasKey('total', $existingOrder);
            /**
             * Check price is the same as product
             */
            $this->assertEquals($existingOrder['price'], $existingOrder['product']['price']);
            if ($existingOrder['product']['discount'] && $existingOrder['quantity'] > 2) {
                $this->assertEquals($existingOrder['total'], $existingOrder['price'] * $existingOrder['quantity'] * 0.8);
            } else {
                $this->assertEquals($existingOrder['total'], $existingOrder['price'] * $existingOrder['quantity']);
            }
            /**
             * Delete order.
             */
            $client->request('DELETE', '/api/orders/'. $existingOrder['id']);
            $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
        }
    }
}
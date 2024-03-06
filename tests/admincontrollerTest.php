<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testEditCategory()
    {
        $client = static::createClient();
        $client->request('POST', '/admin/editCategory/1', ['name' => 'Updated Category']); // assuming 1 is a valid category ID

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testProduct()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/product');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSaveProduct()
    {
        $client = static::createClient();
        $client->request('POST', '/admin/saveProduct', [
            'name' => 'Test Product',
            'description' => 'Product Description',
            'category_id' => 1, // assuming 1 is a valid category ID
            'path' => 'path/to/image.jpg', // provide a valid path for testing
            'price' => 10.99,
        ]);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testUpdateProduct()
    {
        $client = static::createClient();
        $client->request('POST', '/admin/updateProduct/1', [
            'name' => 'Updated Product',
            'description' => 'Updated Description',
            'category_id' => 1, // assuming 1 is a valid category ID
            'path' => 'path/to/updated-image.jpg', // provide a valid path for testing
            'price' => 15.99,
        ]); // assuming 1 is a valid product ID

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteProduct()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/deleteProduct/1'); // assuming 1 is a valid product ID

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPromotion()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/promotion');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testStorePromotion()
    {
        $client = static::createClient();
        $client->request('POST', '/admin/storePromotion', [
            'product' => 1, // assuming 1 is a valid product ID
            'start' => '2022-01-01', // provide a valid date for testing
            'end' => '2022-02-01', // provide a valid date for testing
            'percent' => 20,
        ]);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPromotionDelete()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/promotionDelete/1'); // assuming 1 is a valid promotion ID

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

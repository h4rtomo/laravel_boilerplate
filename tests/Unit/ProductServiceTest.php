<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Services\ProductService;

class ProductServiceTest extends TestCase
{
    public function testGetProducts()
    {
        // Create a product in the database for testing
        Product::factory()->create();

        // Call the getProducts method
        $products = ProductService::getProducts();

        // Assert that the $products variable is not empty
        $this->assertNotEmpty($products);
    }

    public function testCreateProduct()
    {
        $dataProduct = [
            'name' => 'New Product',
            'description' => 'New Product',
            'price' => 20000,
            'stock' => 19,
        ];

        $createdProduct = ProductService::createProduct($dataProduct);

        $this->assertDatabaseHas('products', [
            'id' => $createdProduct->id,
            'name' => 'New Product',
            'description' => 'New Product',
            'price' => 20000,
            'stock' => 19,
        ]);
    }

    public function testGetProductById()
    {
        // Create a product in the database for testing
        $product = Product::factory()->create();

        // Call the getProductById method with the created product's ID
        $retrievedProduct = ProductService::getProductById($product->id);

        // Assert that the retrieved product is not null
        $this->assertNotNull($retrievedProduct);

        // Assert that the retrieved product has property name
        $this->assertArrayHasKey('name', $retrievedProduct->toArray());
        $this->assertArrayHasKey('description', $retrievedProduct->toArray());
        $this->assertArrayHasKey('price', $retrievedProduct->toArray());
        $this->assertArrayHasKey('stock', $retrievedProduct->toArray());
    }

    public function testUpdateProduct()
    {
        // Create a product in the database for testing
        $product = Product::factory()->create();

        // Call the updateProduct method with the created product's ID and updated data
        $updatedProduct = ProductService::updateProduct($product->id, ['name' => 'Updated Product']);

        // Assert that the updated product matches the expected values
        $this->assertEquals('Updated Product', $updatedProduct->name);
    }

    public function testDeleteProduct()
    {
        // Create a product in the database for testing
        $product = Product::factory()->create();

        // Call the deleteProduct method with the created product's ID
        ProductService::deleteProduct($product->id);

        // Assert that the product is no longer in the database
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}

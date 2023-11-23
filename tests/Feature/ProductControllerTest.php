<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Http\Response;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function testGetProductsResponse(): void
    {
        // Create a product in the database for testing
        Product::factory()->create();

        $response = $this->get('/api/v1/products');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price',
                        'stock',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    public function testCreateProductResponse(): void
    {
        // send a POST request to the store method
        $response = $this->post('/api/v1/products', [
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 20000,
            'stock' => 19,
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'message'
            ]);


        // send a POST request with missing parameters
        $response = $this->post('/api/v1/products', [
            'description' => 'This is a test product.',
            'price' => 20000,
            'stock' => 19,
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure([
                'error'
            ]);
    }

    public function testGetProductByIdResponse(): void
    {
        // Create a product in the database for testing
        $product = Product::factory()->create();

        $response = $this->get('/api/v1/products/' . $product->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'name',
                'description',
                'price',
                'stock',
                'created_at',
                'updated_at'
            ]);


        // send a GET request to invalid id
        $response = $this->get('/api/v1/products/' . $product->id + 1);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testUpdateProductResponse(): void
    {
        // Create a product in the database for testing
        $product = Product::factory()->create();

        // send a PUT request to the store method
        $response = $this->put('/api/v1/products/' . $product->id, [
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 20000,
            'stock' => 19,
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message'
            ]);

        // send a PUT request with missing parameters
        $response = $this->put('/api/v1/products/' . $product->id, [
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 20000,
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure([
                'error'
            ]);
    }


    public function testDeleteProductResponse(): void
    {
        // Create a product in the database for testing
        $product = Product::factory()->create();

        // send a DELETE request
        $response = $this->delete('/api/v1/products/' . $product->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message'
            ]);

        // send a DELETE request to invalid id
        $response = $this->delete('/api/v1/products/' . $product->id);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}

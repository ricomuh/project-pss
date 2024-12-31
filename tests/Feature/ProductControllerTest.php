<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and authenticate using Sanctum
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    /**
     * Test the index method.
     */
    public function testIndex()
    {
        Product::factory()->count(15)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'description', 'price', 'stock', 'created_at', 'updated_at']
                ],
                'links',
            ]);
    }

    /**
     * Test the store method.
     */
    public function testStore()
    {
        $productData = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 99.99,
            'stock' => 10,
        ];

        $response = $this->postJson('/api/products', $productData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Product created successfully',
                'product' => $productData
            ]);

        $this->assertDatabaseHas('products', $productData);
    }

    /**
     * Test the show method.
     */
    public function testShow()
    {
        $product = Product::factory()->create();

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertStatus(200)
            ->assertJson($product->toArray());
    }

    /**
     * Test the update method.
     */
    public function testUpdate()
    {
        $product = Product::factory()->create();

        $updatedData = [
            'name' => 'Updated Product',
            'description' => 'Updated Description',
            'price' => 199.99,
            'stock' => 20,
        ];

        $response = $this->putJson('/api/products/' . $product->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Product updated successfully',
                'product' => $updatedData
            ]);

        $this->assertDatabaseHas('products', $updatedData);
    }

    /**
     * Test the destroy method.
     */
    public function testDestroy()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Product deleted successfully']);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}

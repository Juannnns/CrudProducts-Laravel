<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_seeds_products()
    {
        $this->seed();
        $this->assertDatabaseCount('products', 50);
    }

    public function test_it_displays_products()
    {
        Product::factory()->create(['nombre' => 'Test Product']);
        $response = $this->get('/productos');
        $response->assertStatus(200);
        $response->assertSee('Test Product');
    }

    public function test_it_can_create_product()
    {
        $response = $this->post('/productos', [
            'nombre' => 'New Product',
            'precio' => 100
        ]);

        $response->assertRedirect('/productos');
        $this->assertDatabaseHas('products', ['nombre' => 'New Product']);
    }

    public function test_it_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete("/productos/{$product->id}");

        $response->assertRedirect('/productos');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
    public function test_it_can_update_product()
    {
        $product = Product::factory()->create(['nombre' => 'Old Name', 'precio' => 10]);

        $response = $this->put("/productos/{$product->id}", [
            'nombre' => 'New Name',
            'precio' => 20
        ]);

        $response->assertRedirect('/productos');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'nombre' => 'New Name',
            'precio' => 20
        ]);
    }
}

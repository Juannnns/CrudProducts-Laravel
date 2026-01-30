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
        $this->seed(\Database\Seeders\ProductSeeder::class);
        $this->assertDatabaseCount('products', 50);
    }

    public function test_it_displays_products()
    {
        $user = \App\Models\User::factory()->withPersonalTeam()->create();
        Product::factory()->create(['nombre' => 'Test Product', 'user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/productos');
        $response->assertStatus(200);
        $response->assertSee('Test Product');
    }

    public function test_it_can_create_product()
    {
        $user = \App\Models\User::factory()->withPersonalTeam()->create();

        $response = $this->actingAs($user)->post('/productos', [
            'nombre' => 'New Product',
            'precio' => 100
        ]);

        $response->assertRedirect('/productos');
        $this->assertDatabaseHas('products', ['nombre' => 'New Product', 'user_id' => $user->id]);
    }

    public function test_it_can_delete_product()
    {
        $user = \App\Models\User::factory()->withPersonalTeam()->create();
        $product = Product::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/productos/{$product->id}");

        $response->assertRedirect('/productos');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_it_can_update_product()
    {
        $user = \App\Models\User::factory()->withPersonalTeam()->create();
        $product = Product::factory()->create(['nombre' => 'Old Name', 'precio' => 10, 'user_id' => $user->id]);

        $response = $this->actingAs($user)->put("/productos/{$product->id}", [
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

    public function test_it_validates_product_creation()
    {
        $user = \App\Models\User::factory()->withPersonalTeam()->create();

        $response = $this->actingAs($user)->post('/productos', [
            'nombre' => '',
            'precio' => -5
        ]);

        $response->assertSessionHasErrors(['nombre', 'precio']);
    }
}

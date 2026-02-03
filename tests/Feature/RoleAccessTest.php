<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_all_products()
    {
        $admin = User::factory()->withPersonalTeam()->create(['role' => 'admin']);
        $user = User::factory()->withPersonalTeam()->create(['role' => 'user']);
        $category = \App\Models\Category::factory()->create();

        $productAdmin = Product::create(['nombre' => 'Admin Product', 'precio' => 100, 'user_id' => $admin->id, 'category_id' => $category->id]);
        $productUser = Product::create(['nombre' => 'User Product', 'precio' => 50, 'user_id' => $user->id, 'category_id' => $category->id]);

        $response = $this->actingAs($admin)->get('/productos');

        $response->assertStatus(200);
        $response->assertSee('Admin Product');
        $response->assertSee('User Product');
    }

    public function test_user_can_only_see_own_products()
    {
        $userA = User::factory()->withPersonalTeam()->create(['role' => 'user']);
        $userB = User::factory()->withPersonalTeam()->create(['role' => 'user']);
        $category = \App\Models\Category::factory()->create();

        $productA = Product::create(['nombre' => 'Product A', 'precio' => 100, 'user_id' => $userA->id, 'category_id' => $category->id]);
        $productB = Product::create(['nombre' => 'Product B', 'precio' => 50, 'user_id' => $userB->id, 'category_id' => $category->id]);

        $response = $this->actingAs($userA)->get('/productos');

        $response->assertStatus(200);
        $response->assertSee('Product A');
        $response->assertDontSee('Product B');
    }

    public function test_user_can_edit_own_product()
    {
        $user = User::factory()->withPersonalTeam()->create(['role' => 'user']);
        $category = \App\Models\Category::factory()->create();
        $product = Product::create(['nombre' => 'My Product', 'precio' => 100, 'user_id' => $user->id, 'category_id' => $category->id]);

        $response = $this->actingAs($user)->get("/productos/{$product->id}/editar");
        $response->assertStatus(200);

        $response = $this->actingAs($user)->put("/productos/{$product->id}", [
            'nombre' => 'Updated Product',
            'precio' => 150,
            'category_id' => $category->id,
        ]);

        $response->assertRedirect('/productos');
        $this->assertDatabaseHas('products', ['nombre' => 'Updated Product']);
    }

    public function test_user_cannot_edit_others_product()
    {
        $userA = User::factory()->withPersonalTeam()->create(['role' => 'user']);
        $userB = User::factory()->withPersonalTeam()->create(['role' => 'user']);
        $category = \App\Models\Category::factory()->create();
        $productB = Product::create(['nombre' => 'Product B', 'precio' => 50, 'user_id' => $userB->id, 'category_id' => $category->id]);

        $response = $this->actingAs($userA)->get("/productos/{$productB->id}/editar");
        $response->assertStatus(403);

        $response = $this->actingAs($userA)->put("/productos/{$productB->id}", [
            'nombre' => 'Hacked Product',
            'precio' => 0,
            'category_id' => $category->id,
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_edit_others_product()
    {
        $admin = User::factory()->withPersonalTeam()->create(['role' => 'admin']);
        $user = User::factory()->withPersonalTeam()->create(['role' => 'user']);
        $category = \App\Models\Category::factory()->create();
        $product = Product::create(['nombre' => 'User Product', 'precio' => 50, 'user_id' => $user->id, 'category_id' => $category->id]);

        $response = $this->actingAs($admin)->put("/productos/{$product->id}", [
            'nombre' => 'Admin Updated',
            'precio' => 200,
            'category_id' => $category->id,
        ]);

        $response->assertRedirect('/productos');
        $this->assertDatabaseHas('products', ['nombre' => 'Admin Updated']);
    }
}

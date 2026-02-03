<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestHelpers;

uses(TestHelpers::class);

// Variables compartidas para todos los tests
beforeEach(function () {
    // Se ejecuta antes de cada test
    $this->user = User::factory()->withPersonalTeam()->create(['role' => 'admin']);
    $this->category = Category::factory()->create(['name' => 'Test Category']);
    Storage::fake('public');
});

// Test de visualización del listado
test('authenticated user can view products list', function () {
    Product::factory()->count(5)->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);

    $response = $this->actingAs($this->user)->get('/productos');

    $response->assertStatus(200)
        ->assertViewIs('productos.index')
        ->assertViewHas('productos');
})->group('products', 'feature');

// Test de visualización del formulario de creación
test('authenticated user can view create product form', function () {
    $response = $this->actingAs($this->user)->get('/productos/crear');

    $response->assertStatus(200)
        ->assertViewIs('productos.create')
        ->assertSee('Nombre')
        ->assertSee('Precio')
        ->assertSee('Categoría');
})->group('products', 'feature');

// Test de creación de producto con imagen
test('authenticated user can create a product with image', function () {
    $image = UploadedFile::fake()->image('product.jpg');

    $response = $this->actingAs($this->user)->post('/productos', [
        'nombre' => 'iPhone 15 Pro',
        'precio' => 999.99,
        'category_id' => $this->category->id,
        'description' => 'Latest iPhone model',
        'image' => $image,
    ]);

    $response->assertRedirect('/productos');

    expect(Product::where('nombre', 'iPhone 15 Pro')->exists())->toBeTrue();
    Storage::disk('public')->assertExists('products/' . $image->hashName());
})->group('products', 'feature');

// Test de creación con galería de imágenes
test('authenticated user can create product with gallery images', function () {
    $mainImage = UploadedFile::fake()->image('main.jpg');
    $gallery1 = UploadedFile::fake()->image('gallery1.jpg');
    $gallery2 = UploadedFile::fake()->image('gallery2.jpg');

    $response = $this->actingAs($this->user)->post('/productos', [
        'nombre' => 'MacBook Pro',
        'precio' => 1999.99,
        'category_id' => $this->category->id,
        'description' => 'Powerful laptop',
        'image' => $mainImage,
        'gallery' => [$gallery1, $gallery2],
    ]);

    $product = Product::where('nombre', 'MacBook Pro')->first();

    expect($product->images)->toHaveCount(2);
    Storage::disk('public')->assertExists('product_gallery/' . $gallery1->hashName());
})->group('products', 'feature');

// Test de validación - campos requeridos
test('product creation requires name, price, category and image', function () {
    $response = $this->actingAs($this->user)->post('/productos', []);

    $response->assertSessionHasErrors(['nombre', 'precio', 'category_id', 'image']);
})->group('products', 'feature');

// Test de actualización de producto
test('authenticated user can update a product', function () {
    $product = Product::factory()->create([
        'nombre' => 'Old Name',
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);

    $response = $this->actingAs($this->user)->put("/productos/{$product->id}", [
        'nombre' => 'New Name',
        'precio' => $product->precio,
        'category_id' => $this->category->id,
    ]);

    $response->assertRedirect('/productos');
    expect($product->fresh()->nombre)->toBe('New Name');
})->group('products', 'feature');

// Test de eliminación de producto
test('authenticated user can delete a product', function () {
    $product = Product::factory()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);

    $response = $this->actingAs($this->user)->delete("/productos/{$product->id}");

    $response->assertRedirect('/productos');
    expect(Product::find($product->id))->toBeNull();
})->group('products', 'feature');

// Test de visualización de detalle
test('authenticated user can view product details', function () {
    $product = Product::factory()->create([
        'nombre' => 'Test Product',
        'description' => 'Test Description',
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);

    $response = $this->actingAs($this->user)->get("/productos/{$product->id}");

    $response->assertStatus(200)
        ->assertViewIs('productos.show')
        ->assertSee('Test Product')
        ->assertSee('Test Description');
})->group('products', 'feature');

// Test de acceso no autorizado
test('guest users cannot access products', function () {
    $response = $this->get('/productos');

    $response->assertRedirect('/login');
})->group('products', 'feature');

// Test de usuario no puede editar producto de otro usuario
test('user cannot edit another users product', function () {
    $otherUser = User::factory()->withPersonalTeam()->create(['role' => 'user']);
    $product = Product::factory()->create([
        'user_id' => $otherUser->id,
        'category_id' => $this->category->id,
    ]);

    $regularUser = User::factory()->withPersonalTeam()->create(['role' => 'user']);

    $response = $this->actingAs($regularUser)
        ->put("/productos/{$product->id}", [
            'nombre' => 'Hacked Name',
            'precio' => 1000,
            'category_id' => $this->category->id,
        ]);

    $response->assertStatus(403);
})->group('products', 'feature');

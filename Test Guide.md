# 🧪 Guía de Testing con Pest en Laravel

## Comandos básicos

```bash
# Ejecutar todos los tests
php artisan test

# O directamente con Pest
./vendor/bin/pest

# Ejecutar solo tests unitarios
php artisan test --testsuite=Unit

# Ejecutar solo tests de features
php artisan test --testsuite=Feature

# Ejecutar un archivo específico
php artisan test tests/Feature/ProductCrudTest.php

# Ejecutar con cobertura (requiere Xdebug)
php artisan test --coverage

# Ejecutar en paralelo (más rápido)
php artisan test --parallel
```

## Estructura básica de un test con Pest

### Test simple
```php
test('description of what it tests', function () {
    // Arrange (preparar)
    $user = User::factory()->create();
    
    // Act (actuar)
    $result = $user->isAdmin();
    
    // Assert (afirmar)
    expect($result)->toBeFalse();
});
```

### Usando `it()` para tests más descriptivos
```php
it('can create a product', function () {
    $product = Product::factory()->create();
    
    expect($product)->toBeInstanceOf(Product::class);
});
```

## Expectaciones más comunes

```php
// Comparaciones
expect($value)->toBe(100);              // ===
expect($value)->toEqual($expected);     // ==
expect($value)->toBeTrue();
expect($value)->toBeFalse();
expect($value)->toBeNull();

// Tipos
expect($value)->toBeInt();
expect($value)->toBeString();
expect($value)->toBeArray();
expect($value)->toBeInstanceOf(Product::class);

// Números
expect($number)->toBeGreaterThan(10);
expect($number)->toBeLessThan(100);
expect($number)->toBePositive();
expect($number)->toBeNegative();

// Arrays y colecciones
expect($array)->toHaveCount(5);
expect($array)->toContain('item');
expect($array)->toHaveKey('name');
expect($collection)->toBeEmpty();

// Strings
expect($string)->toStartWith('Hello');
expect($string)->toEndWith('world');
expect($string)->toContain('Laravel');
expect($string)->toMatch('/regex/');

// JSON
expect($response->json())->toHaveKey('data');
expect($response->json('data'))->toBeArray();

// Encadenamiento
expect($user->name)->toBe('John')
    ->and($user->email)->toBe('john@example.com')
    ->and($user->isActive())->toBeTrue();
```

## Hooks (Setup y Teardown)

```php
// Se ejecuta ANTES de cada test
beforeEach(function () {
    $this->user = User::factory()->create();
});

// Se ejecuta DESPUÉS de cada test
afterEach(function () {
    // Limpieza
});

// Se ejecuta UNA VEZ antes de todos los tests
beforeAll(function () {
    // Setup global
});

// Se ejecuta UNA VEZ después de todos los tests
afterAll(function () {
    // Limpieza global
});
```

## Testing HTTP Requests (Feature Tests)

```php
test('user can view dashboard', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/dashboard');
    
    $response->assertStatus(200);
    $response->assertViewIs('dashboard');
    $response->assertSee('Welcome');
});

test('validation fails without required fields', function () {
    $response = $this->post('/productos', []);
    
    $response->assertSessionHasErrors(['nombre', 'precio']);
});
```

## Assertions de Laravel disponibles

```php
// Status
$response->assertStatus(200);
$response->assertOk();
$response->assertNotFound();
$response->assertForbidden();
$response->assertRedirect('/path');

// View
$response->assertViewIs('products.index');
$response->assertViewHas('products');
$response->assertSee('Text on page');
$response->assertDontSee('Hidden text');

// JSON
$response->assertJson(['key' => 'value']);
$response->assertJsonStructure(['data' => ['*' => ['id', 'name']]]);

// Database
$this->assertDatabaseHas('products', ['nombre' => 'iPhone']);
$this->assertDatabaseMissing('products', ['nombre' => 'Deleted']);
$this->assertDatabaseCount('products', 10);

// Session
$response->assertSessionHas('success');
$response->assertSessionHasErrors(['field']);
```

## Database Testing

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

// Usa RefreshDatabase para limpiar DB después de cada test
uses(RefreshDatabase::class);

test('product is stored in database', function () {
    $product = Product::factory()->create(['nombre' => 'Test']);
    
    $this->assertDatabaseHas('products', ['nombre' => 'Test']);
});
```

## Mocking y Fakes

```php
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

test('file upload works', function () {
    Storage::fake('public');
    
    $file = UploadedFile::fake()->image('photo.jpg');
    
    // Tu código que sube el archivo
    
    Storage::disk('public')->assertExists('uploads/' . $file->hashName());
});
```

## Datasets (Reutilizar tests con diferentes datos)

```php
it('validates price', function ($price, $valid) {
    $response = $this->post('/productos', [
        'nombre' => 'Test',
        'precio' => $price,
    ]);
    
    if ($valid) {
        $response->assertSessionDoesntHaveErrors('precio');
    } else {
        $response->assertSessionHasErrors('precio');
    }
})->with([
    [100, true],
    [-10, false],
    [0, false],
    ['abc', false],
]);
```

## Grupos de tests

```php
// En Pest.php o al inicio del archivo
pest()->group('products');

// Solo ejecutar grupo
php artisan test --group=products

// Excluir grupo
php artisan test --exclude-group=slow
```

## Tests pendientes

```php
test('advanced feature')->todo();

test('feature being developed', function () {
    // ...
})->skip('Not implemented yet');
```

## Tips y mejores prácticas

1. **Nombre descriptivo**: El nombre del test debe explicar QUÉ hace, no CÓMO
2. **AAA Pattern**: Arrange, Act, Assert
3. **Un concepto por test**: No probar múltiples cosas en un solo test
4. **Tests independientes**: Cada test debe poder ejecutarse solo
5. **Usa factories**: No crees datos manualmente
6. **Limpia después**: Usa `RefreshDatabase` en Feature tests

## Ejemplo completo

```php
<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
});

test('admin can create product', function () {
    $response = $this->actingAs($this->admin)
        ->post('/productos', [
            'nombre' => 'iPhone 15',
            'precio' => 999,
            'category_id' => 1,
        ]);
    
    $response->assertRedirect('/productos');
    
    expect(Product::where('nombre', 'iPhone 15')->exists())->toBeTrue();
});
```

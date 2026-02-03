<?php

// Unit tests should test individual methods/logic WITHOUT database
// For database interactions, use Feature tests instead

use App\Models\Product;
use App\Models\Category;
use App\Models\User;

// Test simple object creation
test('product model can be instantiated', function () {
    $product = new Product();

    expect($product)->toBeInstanceOf(Product::class);
});

// Test fillable attributes
test('product has correct fillable attributes', function () {
    $product = new Product();

    $fillable = $product->getFillable();

    expect($fillable)->toContain('nombre')
        ->and($fillable)->toContain('precio')
        ->and($fillable)->toContain('description')
        ->and($fillable)->toContain('image_path')
        ->and($fillable)->toContain('category_id')
        ->and($fillable)->toContain('user_id');
});

// Test table name
test('product uses correct table name', function () {
    $product = new Product();

    expect($product->getTable())->toBe('products');
});

// Test casting (if you have any)
test('product has correct casts', function () {
    $product = new Product();

    $casts = $product->getCasts();

    expect($casts)->toHaveKey('id');
});

// Test attribute manipulation
test('product can set and get attributes', function () {
    $product = new Product();
    $product->nombre = 'Test Product';
    $product->precio = 99.99;

    expect($product->nombre)->toBe('Test Product')
        ->and($product->precio)->toBe(99.99);
});


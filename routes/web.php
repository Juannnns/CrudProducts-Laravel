<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductoController;
use App\Http\Controllers\Web\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $productos = \App\Models\Product::with('category')->orderBy('created_at', 'desc')->get();
        return view('dashboard', compact('productos'));
    })->name('dashboard');
    Route::get('/productos', [ProductoController::class, 'index'])->name("productos.index");
    Route::get('/productos/crear', [ProductoController::class, 'create'])->name("productos.create");
    Route::get('/productos/{id}', [ProductoController::class, 'show'])->name("productos.show");
    Route::post('/productos', [ProductoController::class, 'store'])->name("productos.store");
    Route::get('/productos/{id}/editar', [ProductoController::class, 'edit'])->name("productos.edit");
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name("productos.update");
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name("productos.destroy");
});

Route::fallback(function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('home');
});                     

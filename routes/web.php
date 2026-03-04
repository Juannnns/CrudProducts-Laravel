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
    Route::get('/menu/crear', [ProductoController::class, 'create'])->name("productos.create");
    Route::post('/menu', [ProductoController::class, 'store'])->name("productos.store");
    Route::get('/menu/{id}/editar', [ProductoController::class, 'edit'])->name("productos.edit");
    Route::put('/menu/{id}', [ProductoController::class, 'update'])->name("productos.update");
    Route::delete('/menu/{id}', [ProductoController::class, 'destroy'])->name("productos.destroy");
});

Route::get('/menu', [ProductoController::class, 'index'])->name("productos.index");
Route::get('/menu/{id}', [ProductoController::class, 'show'])->name("productos.show");

Route::fallback(function () {
    // Si es una petición a la API, devolver JSON 404
    if (request()->is('api/*')) {
        return response()->json([
            'success' => false,
            'message' => 'Ruta no encontrada'
        ], 404);
    }

    // Para peticiones web, redirigir como antes
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('home');
});
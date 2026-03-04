<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $totalProductos = \App\Models\Product::count();
        $totalCategorias = \App\Models\Category::count();
        
        $ultimoProducto = \App\Models\Product::with('category')
            ->latest()
            ->first();

        // Calcular escalón para productos (ej. si hay 345 -> '300+', si hay 42 -> '42')
        $steppedProductos = $totalProductos;
        if ($totalProductos >= 100) {
            $steppedProductos = floor($totalProductos / 100) * 100 . '+';
        } elseif ($totalProductos >= 50) {
            $steppedProductos = '50+';
        }

        // Calcular escalón para categorías
        $steppedCategorias = $totalCategorias;
        if ($totalCategorias >= 50) {
            $steppedCategorias = floor($totalCategorias / 10) * 10 . '+';
        } elseif ($totalCategorias >= 10) {
            $steppedCategorias = '10+';
        }

        return view('welcome', compact('totalProductos', 'totalCategorias', 'ultimoProducto', 'steppedProductos', 'steppedCategorias'));
    }
}

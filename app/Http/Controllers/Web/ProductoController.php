<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Product::paginate(10);
        return view('productos.index', compact('productos'));
    }

    public function show($id)
    {
        $producto = Product::find($id);
        if (!$producto) {
            return "Producto no encontrado";
        }
        return view('productos.show', compact('producto'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function edit($id)
    {
        $producto = Product::find($id);
        if (!$producto) {
            return "Producto no encontrado";
        }
        return view('productos.edit', compact('producto'));
    }

    public function store(Request $request)
    {
        Product::create($request->all());
        return redirect('/productos');
    }

    public function update(Request $request, $id)
    {
        $producto = Product::find($id);
        if (!$producto) {
            return "Producto no encontrado";
        }
        $producto->update($request->all());
        return redirect('/productos');
    }


    public function destroy($id)
    {
        Product::destroy($id);
        return redirect('/productos');
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductoController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $productos = Product::paginate(10);
        } else {
            $productos = auth()->user()->products()->paginate(10);
        }
        return view('productos.index', compact('productos'));
    }

    public function show($id)
    {
        $producto = Product::find($id);
        if (!$producto) {
            return "Producto no encontrado";
        }

        if (!auth()->user()->isAdmin() && $producto->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
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

        if (!auth()->user()->isAdmin() && $producto->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('productos.edit', compact('producto'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        Product::create($data);
        return redirect('/productos');
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $producto = Product::find($id);
        if (!$producto) {
            return "Producto no encontrado";
        }

        if (!auth()->user()->isAdmin() && $producto->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $producto->update($request->validated());
        return redirect('/productos');
    }


    public function destroy($id)
    {
        $producto = Product::find($id);
        if ($producto) {
            if (!auth()->user()->isAdmin() && $producto->user_id != auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
            $producto->delete();
        }
        return redirect('/productos');
    }
}

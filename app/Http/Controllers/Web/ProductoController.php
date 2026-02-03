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
            $productos = Product::with('category')->paginate(10);
        } else {
            $productos = auth()->user()->products()->with('category')->paginate(10);
        } return view('productos.index', compact('productos'));
    }

    public function show($id)
    {
        $producto = Product::with('category')->find($id);
        if (!$producto) {
            return "Producto no encontrado";
        } if (!auth()->user()->isAdmin() && $producto->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        } return view('productos.show', compact('producto'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('productos.create', compact('categories'));
    }

    public function edit($id)
    {
        $producto = Product::find($id);
        if (!$producto) {
            return "Producto no encontrado";
        } if (!auth()->user()->isAdmin() && $producto->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        } $categories = \App\Models\Category::all();
        return view('productos.edit', compact('producto', 'categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_path'] = $path;
        }

        $product = Product::create($data);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('product_gallery', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }
        return redirect('/productos');
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $producto = Product::find($id);
        if (!$producto) {
            return "Producto no encontrado";
        } if (!auth()->user()->isAdmin() && $producto->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validated();

        // Update Main Image
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($producto->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($producto->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($producto->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $producto->update($data);

        // Upload new gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                // Check if 5 limit is reached
                if ($producto->images()->count() >= 5) {
                    break;
                }
                $path = $image->store('product_gallery', 'public');
                $producto->images()->create(['image_path' => $path]);
            }
        }

        // Delete selected gallery images
        if ($request->has('delete_images')) {
            foreach ($request->input('delete_images') as $imageId) {
                $image = $producto->images()->find($imageId);
                if ($image) {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($image->image_path)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
                    }
                    $image->delete();
                }
            }
        }

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

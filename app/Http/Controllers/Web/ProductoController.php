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
        $categories = \App\Models\Category::all();
        $categoryFilter = request('category');

        if (auth()->user()->isAdmin()) {
            $productos = Product::with(['category', 'images'])
                ->when($categoryFilter, function($query) use ($categoryFilter) {
                    return $query->where('category_id', $categoryFilter);
                })
                ->paginate(10)
                ->appends(['category' => $categoryFilter]);
        } else {
            $productos = auth()->user()->products()->with(['category', 'images'])
                ->when($categoryFilter, function($query) use ($categoryFilter) {
                    return $query->where('category_id', $categoryFilter);
                })
                ->paginate(10)
                ->appends(['category' => $categoryFilter]);
        }
        
        return view('productos.index', compact('productos', 'categories', 'categoryFilter'));
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
        
        // Guardar imagen principal
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_path'] = $path;
        }

        // Crear el producto
        $product = Product::create($data);

        // Guardar imágenes adicionales (galería) - máximo 5
        if ($request->hasFile('gallery')) {
            $galleryImages = $request->file('gallery');
            $count = 0;
            
            foreach ($galleryImages as $image) {
                if ($count >= 5) {
                    break; // Límite de 5 imágenes adicionales
                }
                
                $path = $image->store('product_gallery', 'public');
                $product->images()->create([
                    'image_path' => $path
                ]);
                
                $count++;
            }
        }
        
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente con todas sus imágenes');
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

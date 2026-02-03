<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/products
     */
    public function index(): JsonResponse
    {
        $user = auth()->user();

        if ($user && $user->isAdmin()) {
            $productos = Product::with('category', 'user')->paginate(10);
        } elseif ($user) {
            $productos = $user->products()->with('category')->paginate(10);
        } else {
            // Si no está autenticado, mostrar todos los productos (acceso público)
            $productos = Product::with('category', 'user')->paginate(10);
        }

        return response()->json([
            'success' => true,
            'data' => $productos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/products
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        // Handle main image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_path'] = $path;
        }

        $product = Product::create($data);

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('product_gallery', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        $product->load('category', 'images');

        return response()->json([
            'success' => true,
            'message' => 'Producto creado exitosamente',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     * GET /api/products/{id}
     */
    public function show($id): JsonResponse
    {
        $producto = Product::with('category', 'user', 'images')->find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $user = auth()->user();

        // Verificar permisos
        if ($user && !$user->isAdmin() && $producto->user_id != $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $producto
        ]);
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/products/{id}
     */
    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        $producto = Product::find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $user = auth()->user();

        // Verificar permisos
        if (!$user || (!$user->isAdmin() && $producto->user_id != $user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
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

        $producto->load('category', 'images');

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado exitosamente',
            'data' => $producto
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/products/{id}
     */
    public function destroy($id): JsonResponse
    {
        $producto = Product::find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $user = auth()->user();

        // Verificar permisos
        if (!$user || (!$user->isAdmin() && $producto->user_id != $user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        // Delete images from storage
        if ($producto->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($producto->image_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($producto->image_path);
        }

        foreach ($producto->images as $image) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($image->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
            }
        }

        $producto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente'
        ]);
    }
}

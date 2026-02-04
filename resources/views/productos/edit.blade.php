<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar producto') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4 sm:p-6 lg:p-8">
                    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto">
                        @csrf
                        @method('PUT')
                
                        <div class="mb-4">
                            <x-label for="nombre" value="{{ __('Nombre') }}" />
                            <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="$producto->nombre" required autofocus />
                        </div>
                
                        <div class="mb-4">
                            <x-label for="precio" value="{{ __('Precio') }}" />
                            <x-input id="precio" class="block mt-1 w-full" type="number" name="precio" :value="$producto->precio" required />
                        </div>

                        <div class="mb-4">
                            <x-label for="category_id" value="{{ __('Categoría') }}" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="" disabled>Seleccione una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $producto->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <x-label for="description" value="{{ __('Descripción') }}" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ $producto->description }}</textarea>
                        </div>

                        <div class="mb-4">
                            <x-label for="image" value="{{ __('Imagen Principal') }}" />
                            @if($producto->image_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $producto->image_path) }}" alt="Imagen actual" class="h-32 sm:h-40 object-cover rounded">
                                </div>
                            @endif
                            <input id="image" type="file" name="image" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                        </div>

                        <div class="mb-4">
                            <x-label value="{{ __('Galería actual') }}" />
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mt-2">
                                @foreach($producto->images as $img)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $img->image_path) }}" class="h-20 sm:h-24 w-full object-cover rounded">
                                        <div class="flex items-center mt-1">
                                            <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="mr-2 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <span class="text-xs text-red-600">Eliminar</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-label for="gallery" value="{{ __('Añadir más fotos a la galería (Máx 5 en total)') }}" />
                            <input id="gallery" type="file" name="gallery[]" multiple class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept="image/*">
                        </div>
                
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 mt-6">
                            <x-button class="w-full sm:w-auto justify-center">
                                {{ __('Guardar cambios') }}
                            </x-button>
                
                            <a href="{{ route('productos.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

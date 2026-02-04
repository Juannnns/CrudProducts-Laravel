<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear producto') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4 sm:p-6 lg:p-8">
                    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto">
                        @csrf
                
                        <div class="mb-4">
                            <x-label for="nombre" value="{{ __('Nombre') }}" />
                            <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus />
                        </div>
                
                        <div class="mb-4">
                            <x-label for="precio" value="{{ __('Precio') }}" />
                            <x-input id="precio" class="block mt-1 w-full" type="number" name="precio" :value="old('precio')" required />
                        </div>

                        <div class="mb-4">
                            <x-label for="category_id" value="{{ __('Categoría') }}" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Seleccione una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <x-label for="description" value="{{ __('Descripción') }}" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <x-label for="image" value="{{ __('Imagen Principal') }}" />
                            <input id="image" type="file" name="image" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept="image/*" required>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Esta imagen aparecerá como la principal del producto (JPG, PNG, GIF - Máx 2MB)</p>
                            <div id="preview-main" class="mt-2"></div>
                        </div>

                        <div class="mb-4">
                            <x-label for="gallery" value="{{ __('Galería de Imágenes (Hasta 5 imágenes)') }}" />
                            <input id="gallery" type="file" name="gallery[]" multiple class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept="image/*">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Selecciona hasta 5 imágenes adicionales para la galería del producto (JPG, PNG, GIF - Máx 2MB cada una)</p>
                            <div id="preview-gallery" class="grid grid-cols-2 sm:grid-cols-3 gap-2 mt-2"></div>
                        </div>

                        <script>
                            // Preview imagen principal
                            document.getElementById('image').addEventListener('change', function(e) {
                                const preview = document.getElementById('preview-main');
                                preview.innerHTML = '';
                                
                                if (e.target.files && e.target.files[0]) {
                                    const reader = new FileReader();
                                    reader.onload = function(event) {
                                        const img = document.createElement('img');
                                        img.src = event.target.result;
                                        img.className = 'h-32 w-32 object-cover rounded-lg border-2 border-indigo-500';
                                        preview.appendChild(img);
                                    };
                                    reader.readAsDataURL(e.target.files[0]);
                                }
                            });

                            // Preview galería
                            document.getElementById('gallery').addEventListener('change', function(e) {
                                const preview = document.getElementById('preview-gallery');
                                preview.innerHTML = '';
                                
                                const files = Array.from(e.target.files).slice(0, 5);
                                
                                files.forEach(file => {
                                    const reader = new FileReader();
                                    reader.onload = function(event) {
                                        const div = document.createElement('div');
                                        div.className = 'relative';
                                        
                                        const img = document.createElement('img');
                                        img.src = event.target.result;
                                        img.className = 'h-24 w-full object-cover rounded-lg border border-gray-300';
                                        
                                        div.appendChild(img);
                                        preview.appendChild(div);
                                    };
                                    reader.readAsDataURL(file);
                                });
                                
                                if (e.target.files.length > 5) {
                                    alert('Solo se pueden seleccionar hasta 5 imágenes para la galería');
                                }
                            });
                        </script>
                
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 mt-6">
                            <x-button class="w-full sm:w-auto justify-center">
                                {{ __('Guardar producto') }}
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

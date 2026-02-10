<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalle del producto') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4 sm:p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10">
                        <!-- Imagen del producto -->
                        <div x-data="{ showModal: false, modalImage: '' }">
                             @if($producto->image_path)
                                <img src="{{ str_starts_with($producto->image_path, 'data:') ? $producto->image_path : asset('storage/' . $producto->image_path) }}" 
                                     alt="{{ $producto->nombre }}" 
                                     class="w-full rounded-xl object-cover shadow-md mb-4 max-h-96 lg:max-h-none cursor-pointer hover:opacity-90 transition"
                                     @click="showModal = true; modalImage = $el.src">
                            @else
                                <img src="https://via.placeholder.com/600?text=Sin+Imagen" alt="Producto Sin Imagen" class="w-full rounded-xl object-cover shadow-md mb-4 bg-gray-200 max-h-96 lg:max-h-none">
                            @endif

                            <!-- Galería -->
                            @if($producto->images->count() > 0)
                                <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                    @foreach($producto->images as $image)
                                        <div class="relative group">
                                            <img src="{{ str_starts_with($image->image_path, 'data:') ? $image->image_path : asset('storage/' . $image->image_path) }}" 
                                                 class="h-20 sm:h-24 w-full object-cover rounded-md shadow-sm border border-gray-200 dark:border-gray-700 cursor-pointer hover:opacity-75 transition" 
                                                 @click="showModal = true; modalImage = $el.src">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Modal / Lightbox -->
                            <div x-show="showModal" 
                                 class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90 p-4"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 style="display: none;"
                                 @click.self="showModal = false"
                                 @keydown.escape.window="showModal = false">
                                
                                <div class="relative max-w-5xl w-full max-h-screen flex justify-center">
                                    <button @click="showModal = false" class="absolute -top-10 right-0 text-white hover:text-gray-300 focus:outline-none">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <img :src="modalImage" class="max-w-full max-h-[90vh] rounded shadow-lg object-contain">
                                </div>
                            </div>
                        </div>

                        <!-- Información del producto -->
                        <div class="flex flex-col justify-between">
                            <div>
                                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                    {{ $producto->nombre }}
                                </h1>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    Category: 
                                    <span class="font-semibold text-gray-700 dark:text-gray-200">
                                        {{ $producto->category ? $producto->category->name : 'Without Category' }}
                                    </span>
                                </p>

                                <p class="text-xl sm:text-2xl text-green-600 dark:text-green-400 font-semibold mb-4">
                                    ${{ $producto->precio }}
                                </p>

                                <div class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                                    <h3 class="font-bold text-base sm:text-lg mb-2">Description:</h3>
                                    <p class="text-sm sm:text-base">
                                        {{ $producto->description ?? 'Without description available.' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Acción -->
                            <div class="mt-4">
                                <a href="{{ route('productos.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

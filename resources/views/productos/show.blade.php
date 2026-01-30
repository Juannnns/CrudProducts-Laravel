<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalle del producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <!-- Imagen del producto -->
                        <div>
                            <img 
                                src="https://via.placeholder.com/600" 
                                alt="Producto"
                                class="w-full rounded-xl object-cover shadow-md"
                            >
                        </div>

                        <!-- Información del producto -->
                        <div class="flex flex-col justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                    {{ $producto->nombre }}
                                </h1>

                                <p class="text-2xl text-green-600 dark:text-green-400 font-semibold mb-4">
                                    ${{ $producto->precio }}
                                </p>

                                <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                                    Este producto está diseñado para ofrecer la mejor experiencia.
                                    Fabricado con materiales de alta calidad y pensado para un uso
                                    cómodo y duradero.
                                </p>

                                <!-- Características -->
                                <ul class="space-y-2 mb-6 text-gray-700 dark:text-gray-300">
                                    <li class="flex items-center">
                                        <span class="text-green-500 mr-2">✔</span> Material premium
                                    </li>
                                    <li class="flex items-center">
                                        <span class="text-green-500 mr-2">✔</span> Garantía de 1 año
                                    </li>
                                    <li class="flex items-center">
                                        <span class="text-green-500 mr-2">✔</span> Diseño ergonómico
                                    </li>
                                    <li class="flex items-center">
                                        <span class="text-green-500 mr-2">✔</span> Envío rápido
                                    </li>
                                </ul>
                            </div>

                            <!-- Acción -->
                            <div>
                                <a href="{{ route('productos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Volver
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

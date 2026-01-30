<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <form action="{{ route('productos.store') }}" method="POST" class="max-w-xl">
                        @csrf
                
                        <div class="mb-4">
                            <x-label for="nombre" value="{{ __('Nombre') }}" />
                            <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus />
                        </div>
                
                        <div class="mb-4">
                            <x-label for="precio" value="{{ __('Precio') }}" />
                            <x-input id="precio" class="block mt-1 w-full" type="number" name="precio" :value="old('precio')" required />
                        </div>
                
                        <div class="flex items-center gap-4 mt-6">
                            <x-button>
                                {{ __('Guardar producto') }}
                            </x-button>
                            
                            <a href="{{ route('productos.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard - Product Management System') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Bienvenida -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8 text-white">
                    <h1 class="text-3xl font-bold mb-2">
                        ¡Welcome, {{ Auth::user()->name }}! 👋
                    </h1>
                    <p class="text-blue-100 text-lg">
                        Complete product management system with Laravel
                    </p>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Productos -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Products</h2>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ count($productos) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mis Productos -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">My Products</h2>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $productos->where('user_id', Auth::id())->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categorías -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Categories</h2>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $productos->pluck('category_id')->unique()->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Funcionalidades -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                        🚀 System Features
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- CRUD Completo -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-start">
                                <span class="text-3xl mr-4">📝</span>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        Complete CRUD of Products
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                                        Create, read, update and delete products with an intuitive interface. Manage all your products from one place.
                                    </p>
                                    <a href="{{ route('productos.index') }}" class="inline-block mt-3 text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                                        See Products →
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-start">
                                <span class="text-3xl mr-4">🏷️</span>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        Category System
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                                        Organize your products by categories for better management and search. Assign multiple products to each category.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-start">
                                <span class="text-3xl mr-4">🖼️</span>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                    Image Management
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                                        Upload product images and galleries. Optimal storage with Laravel Storage and elegant display.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Authentication -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-start">
                                <span class="text-3xl mr-4">🔐</span>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        Authentication with Jetstream
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                                        Robust authentication system with Laravel Jetstream. User management, profiles, and teams.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Access Control -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-start">
                                <span class="text-3xl mr-4">👥</span>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        User Access Control
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                                        Each user can only edit and delete their own products. Role system (admin/user) implemented.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Validations -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-start">
                                <span class="text-3xl mr-4">✅</span>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        Validaciones Robustas
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                                        Validación de datos tanto en frontend como backend. Mensajes de error claros y formularios intuitivos.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--    Quick Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                        ⚡ Quick Actions
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('productos.create') }}" class="flex items-center justify-center px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create New Product
                        </a>

                        <a href="{{ route('productos.index') }}" class="flex items-center justify-center px-6 py-4 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            See All Products
                        </a>

                        <a href="{{ route('profile.show') }}" class="flex items-center justify-center px-6 py-4 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            My Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tecnologías Utilizadas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                        🛠️ Technologies Used
                    </h2>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="text-3xl mb-2">🐘</div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Laravel 11</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Framework PHP</p>
                        </div>

                        <div class="text-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="text-3xl mb-2">🎨</div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Tailwind CSS</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Estilos Modernos</p>
                        </div>

                        <div class="text-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="text-3xl mb-2">🚀</div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Jetstream</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Autenticación</p>
                        </div>

                        <div class="text-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="text-3xl mb-2">🧪</div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Pest PHP</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Testing</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-2xl text-[#d9a05b] leading-tight tracking-tight">
                {{ __('Nuestro Menú') }}
            </h2>
            @auth
            <a href="{{ route('productos.create') }}" class="w-full sm:w-auto text-center inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#d9a05b] to-[#a67c52] border-none rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:scale-105 active:scale-95 transition-all duration-300 shadow-lg shadow-[#d9a05b]/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                {{ __('Nuevo Producto') }}
            </a>
            @endauth
        </div>
    </x-slot>

    <!-- Adicional GSAP Scripts -->
    @push('head')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    @endpush

    <div class="min-h-screen bg-[#0f0b08] py-8 sm:py-16 selection:bg-[#d9a05b]/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Intro Section -->
            <div class="mb-12 text-center" id="menuIntro">
                <span class="inline-block px-4 py-1.5 rounded-full bg-[#d9a05b]/10 border border-[#d9a05b]/20 text-[#d9a05b] text-xs font-bold uppercase tracking-widest mb-4">Experiencia Gastronómica</span>
                <h1 class="text-4xl sm:text-5xl font-black text-white mb-4 tracking-tighter">Sabores que <span class="bg-gradient-to-r from-[#e6b877] to-[#8c6444] bg-clip-text text-transparent">Inspiran</span></h1>
                <p class="text-gray-400 max-w-2xl mx-auto text-lg leading-relaxed">Explora nuestra cuidada selección de platos y productos premium preparados con los más altos estándares de calidad.</p>
            </div>

            <!-- Filtros Premium -->
            <div class="mb-16" id="menuFilters">
                <form method="GET" action="{{ route('productos.index') }}" class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('productos.index') }}" 
                       class="px-6 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ !$categoryFilter ? 'bg-[#d9a05b] text-white shadow-lg shadow-[#d9a05b]/30' : 'bg-white/5 border border-white/10 text-gray-400 hover:bg-white/10 hover:text-white' }}">
                        Todos
                    </a>
                    @foreach($categories as $category)
                        <button type="submit" name="category" value="{{ $category->id }}"
                                class="px-6 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ $categoryFilter == $category->id ? 'bg-[#d9a05b] text-white shadow-lg shadow-[#d9a05b]/30' : 'bg-white/5 border border-white/10 text-gray-400 hover:bg-white/10 hover:text-white' }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </form>
            </div>

            <!-- Grid de Productos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="productGrid">
                @forelse ($productos as $producto)
                    <div class="product-card group relative h-full flex flex-col bg-[#1c1510] rounded-3xl border border-white/5 overflow-hidden transition-all duration-500 hover:border-[#d9a05b]/30 hover:shadow-2xl hover:shadow-[#d9a05b]/10">
                        <!-- Botones de Acción (Admin/Owner) -->
                        @auth
                        <div class="absolute top-4 right-4 z-20 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="{{ route('productos.edit', $producto->id) }}" class="p-2 bg-blue-600/90 backdrop-blur-sm text-white rounded-lg hover:bg-blue-500 transition-colors shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-600/90 backdrop-blur-sm text-white rounded-lg hover:bg-red-500 transition-colors shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                        @endauth

                        <!-- Imagen del Producto -->
                        <div class="relative aspect-square overflow-hidden cursor-pointer" onclick="window.location='{{ route('productos.show', $producto->id) }}'">
                            @if($producto->image_path)
                                <img src="{{ str_starts_with($producto->image_path, 'data:') ? $producto->image_path : asset('storage/' . $producto->image_path) }}" 
                                     alt="{{ $producto->nombre }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-[#2a2018] flex items-center justify-center text-gray-600 uppercase font-black text-4xl">
                                    {{ substr($producto->nombre, 0, 1) }}
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0f0b08] via-transparent to-transparent opacity-60"></div>
                            
                            <!-- Badges -->
                            <div class="absolute bottom-4 left-4 z-10 flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-black/50 backdrop-blur-md border border-white/10 rounded-lg text-xs font-bold text-[#d9a05b]">
                                    {{ $producto->category ? $producto->category->name : 'General' }}
                                </span>
                            </div>
                        </div>

                        <!-- Info del Producto -->
                        <div class="p-6 flex flex-col flex-1 bg-gradient-to-b from-[#1c1510] to-[#150f0b]">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-xl text-white group-hover:text-[#d9a05b] transition-colors line-clamp-1">
                                    {{ $producto->nombre }}
                                </h3>
                                <span class="text-[#d9a05b] font-black text-xl">
                                    ${{ $producto->precio }}
                                </span>
                            </div>
                            <p class="text-gray-500 text-sm line-clamp-2 mb-6 flex-1 leading-relaxed">
                                {{ $producto->description ?? 'Una experiencia culinaria única que combina tradición e innovación en cada bocado.' }}
                            </p>
                            
                            <a href="{{ route('productos.show', $producto->id) }}" class="inline-flex items-center justify-center gap-2 w-full py-3 bg-white/5 hover:bg-[#d9a05b] text-white font-bold rounded-xl transition-all duration-300 border border-white/10 hover:border-transparent group/btn">
                                Ver Detalle
                                <svg class="w-4 h-4 transform transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="inline-flex p-6 rounded-full bg-white/5 mb-6">
                            <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <h3 class="text-white font-bold text-xl mb-2">No hay platos disponibles</h3>
                        <p class="text-gray-500">Pronto tendremos nuevas delicias para ti.</p>
                    </div>
                @endforelse
            </div>

            <!-- Paginación Premium -->
            @if($productos->hasPages())
                <div class="mt-20 flex justify-center custom-pagination">
                    {{ $productos->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .product-card {
            transform-style: preserve-3d;
            perspective: 1000px;
        }
        
        /* Estilos personalizados para paginación de Laravel/Tailwind */
        .custom-pagination nav > div:first-child { display: none; }
        .custom-pagination span[aria-current="page"] > span { @apply bg-[#d9a05b] border-[#d9a05b] text-white rounded-xl mx-1; }
        .custom-pagination a { @apply bg-white/5 border-white/10 text-gray-400 hover:bg-white/10 hover:text-white rounded-xl mx-1 transition-all; }
        .custom-pagination span { @apply bg-white/5 border-white/10 text-gray-600 rounded-xl mx-1; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Animación de entrada con GSAP
            const tl = gsap.timeline({defaults: {ease: "power3.out"}});

            tl.from("#menuIntro > *", {
                y: 30,
                opacity: 0,
                stagger: 0.1,
                duration: 1
            })
            .from("#menuFilters button, #menuFilters a", {
                scale: 0.9,
                opacity: 0,
                stagger: 0.05,
                duration: 0.8
            }, "-=0.6")
            .from(".product-card", {
                y: 50,
                opacity: 0,
                stagger: 0.08,
                duration: 1
            }, "-=0.8");

            // Efecto Hover 3D en las tarjetas
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('mousemove', e => {
                    const rect = card.getBoundingClientRect();
                    const x = (e.clientX - rect.left) / rect.width - 0.5;
                    const y = (e.clientY - rect.top) / rect.height - 0.5;
                    
                    gsap.to(card, {
                        rotationY: x * 10,
                        rotationX: -y * 10,
                        scale: 1.02,
                        duration: 0.4
                    });
                });

                card.addEventListener('mouseleave', () => {
                    gsap.to(card, {
                        rotationY: 0,
                        rotationX: 0,
                        scale: 1,
                        duration: 0.6,
                        ease: "elastic.out(1, 0.5)"
                    });
                });
            });
        });
    </script>
</x-app-layout>


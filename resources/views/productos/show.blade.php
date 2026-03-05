<x-app-layout>
    <!-- Botón Flotante para Volver (Móvil/General) -->
    <div class="fixed top-24 left-6 z-[40]">
        <a href="{{ route('productos.index') }}" class="p-3 bg-black/50 backdrop-blur-md border border-white/10 text-[#d9a05b] rounded-full shadow-2xl hover:scale-110 active:scale-90 transition-all duration-300 group">
            <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
    </div>

    @push('head')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    @endpush

    <div class="min-h-screen bg-[#0f0b08] py-12 sm:py-20 selection:bg-[#d9a05b]/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#1c1510] rounded-[3rem] border border-white/5 overflow-hidden shadow-2xl shadow-black/50" id="productDetail">
                <div class="p-6 sm:p-10 lg:p-16">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">
                        
                        <!-- Columna Imagen -->
                        <div x-data="{ showModal: false, modalImage: '' }" class="space-y-6">
                            <div class="relative group rounded-3xl overflow-hidden aspect-square shadow-2xl border border-white/5 bg-[#2a2018]">
                                @if($producto->image_path)
                                    <img src="{{ str_starts_with($producto->image_path, 'data:') ? $producto->image_path : asset('storage/' . $producto->image_path) }}" 
                                         alt="{{ $producto->nombre }}" 
                                         class="w-full h-full object-cover cursor-pointer hover:scale-105 transition-transform duration-700"
                                         @click="showModal = true; modalImage = $el.src"
                                         id="mainImage">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-700 font-black text-6xl uppercase">
                                        {{ substr($producto->nombre, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                            </div>

                            <!-- Galería Premium -->
                            @if($producto->images->count() > 0)
                                <div class="grid grid-cols-4 gap-4" id="gallery">
                                    @foreach($producto->images as $image)
                                        <div class="relative group aspect-square rounded-2xl overflow-hidden border border-white/5 hover:border-[#d9a05b]/50 transition-all duration-300">
                                            <img src="{{ str_starts_with($image->image_path, 'data:') ? $image->image_path : asset('storage/' . $image->image_path) }}" 
                                                 class="h-full w-full object-cover cursor-pointer hover:opacity-80 transition" 
                                                 @click="showModal = true; modalImage = $el.src">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Modal / Lightbox -->
                            <div x-show="showModal" 
                                 class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-xl p-4"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 style="display: none;"
                                 @click.self="showModal = false"
                                 @keydown.escape.window="showModal = false">
                                
                                <div class="relative max-w-5xl w-full">
                                    <button @click="showModal = false" class="absolute -top-12 right-0 text-white hover:text-[#d9a05b] transition-colors">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                    <img :src="modalImage" class="w-full max-h-[85vh] rounded-2xl shadow-2xl object-contain border border-white/10">
                                </div>
                            </div>
                        </div>

                        <!-- Columna Info -->
                        <div class="flex flex-col justify-center space-y-8" id="productInfo">
                            <div>
                                <span class="px-4 py-1 rounded-full bg-[#d9a05b]/10 border border-[#d9a05b]/20 text-[#d9a05b] text-xs font-bold uppercase tracking-widest mb-4 inline-block">
                                    {{ $producto->category ? $producto->category->name : 'Platillo de Autor' }}
                                </span>
                                <h1 class="text-4xl sm:text-6xl font-black text-white mb-6 leading-none tracking-tighter">
                                    {{ $producto->nombre }}
                                </h1>
                                <div class="flex items-center gap-4 mb-8">
                                    <span class="text-4xl font-black text-[#d9a05b]">${{ $producto->precio }}</span>
                                    <div class="h-2 w-2 rounded-full bg-white/20"></div>
                                    <span class="text-gray-500 font-medium">Impuestos incluidos</span>
                                </div>
                                
                                <div class="prose prose-invert max-w-none">
                                    <h3 class="text-[#d9a05b] font-bold text-lg mb-3 uppercase tracking-widest text-sm">Descripción del Chef</h3>
                                    <p class="text-gray-400 text-lg leading-relaxed">
                                        {{ $producto->description ?? 'Una creación magistral que deleita los sentidos. Cada ingrediente ha sido seleccionado cuidadosamente para ofrecer un equilibrio perfecto de texturas y sabores intensos.' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="pt-8 flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('productos.index') }}" class="flex-1 inline-flex items-center justify-center gap-3 px-8 py-4 bg-white/5 border border-white/10 rounded-2xl text-white font-bold hover:bg-white/10 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    Volver al Menú
                                </a>
                                @auth
                                <a href="{{ route('productos.edit', $producto->id) }}" class="flex-1 inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-[#d9a05b] to-[#a67c52] rounded-2xl text-white font-bold hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-xl shadow-[#d9a05b]/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Editar Platillo
                                </a>
                                @endauth
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tl = gsap.timeline({defaults: {ease: "power4.out"}});

            tl.from("#productDetail", {
                y: 100,
                opacity: 0,
                duration: 1.2,
                borderRadius: "0rem"
            })
            .from("#mainImage", {
                scale: 1.2,
                opacity: 0,
                duration: 1
            }, "-=0.8")
            .from("#gallery > div", {
                y: 20,
                opacity: 0,
                stagger: 0.1,
                duration: 0.8
            }, "-=0.6")
            .from("#productInfo > *", {
                x: 50,
                opacity: 0,
                stagger: 0.1,
                duration: 1
            }, "-=1");
        });
    </script>
</x-app-layout>


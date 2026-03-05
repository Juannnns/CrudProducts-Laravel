@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#d9a05b] text-start text-base font-medium text-[#d9a05b] bg-[#d9a05b]/10 focus:outline-none focus:text-[#e6b877] focus:bg-[#d9a05b]/20 focus:border-[#e6b877] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-400 hover:text-white hover:bg-white/5 hover:border-[#d9a05b]/30 focus:outline-none focus:text-white focus:bg-white/5 focus:border-[#d9a05b]/30 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

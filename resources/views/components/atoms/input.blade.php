@props([
    'type' => 'text',
    'name'    
])

<input
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ old($name) }}"
    class="w-full border border-gray-300 rounded px-3 py-2"
/>
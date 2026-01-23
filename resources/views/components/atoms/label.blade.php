@props (['for'])

<label
    for="{{ $for }}"
    class="block mb-1 font-semibold text-gray-900"
>
    {{ $slot }}
</label>
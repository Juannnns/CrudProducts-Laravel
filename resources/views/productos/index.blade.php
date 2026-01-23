<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-10 bg-gray-100">

    <h1 class="text-2xl font-bold mb-6">Listado de productos</h1>

    <a href="/productos/crear" class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded">
        Crear producto
    </a>

    <table class="w-full bg-white rounded shadow">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2 text-left">#</th>
                <th class="p-2 text-left">Nombre</th>
                <th class="p-2 text-left">Precio</th>
                <th class="p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productos as $producto)
                <tr class="border-t">
                    <td class="p-2">{{ $loop->iteration }}</td>
                    <td class="p-2">{{ $producto->nombre }}</td>
                    <td class="p-2">${{ $producto->precio }}</td>
                    <td class="p-2 flex gap-2">
                        <a href="/productos/{{ $producto->id }}/editar"
                            class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-3 py-1.5 rounded transition">
                             Editar </a>
                        <form action="/productos/{{ $producto->id }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-3 py-1.5 rounded transition">
                                Eliminar 
                            </button>
                        </form>
                        <a href="/productos/{{ $producto->id }}" class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-3 py-1.5 rounded transition">
                            Ver 
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-4 text-center">
                        No hay productos
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="mt-4">
        {{ $productos->links() }}
    </div>

</body>

</html>
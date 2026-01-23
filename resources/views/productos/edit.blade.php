<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Editar producto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-10 bg-gray-100">

    <h1 class="text-2xl font-bold mb-6">Editar producto</h1>

    <form action="{{ route('productos.update', $producto->id) }}" method="POST"
        class="bg-white p-6 rounded shadow w-full max-w-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nombre</label>
            <input type="text" name="nombre" value="{{ $producto->nombre }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Precio</label>
            <input type="number" name="precio" value="{{ $producto->precio }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Guardar cambios
            </button>

            <a href="/productos" class="bg-gray-400 text-white px-4 py-2 rounded">
                Cancelar
            </a>
        </div>
    </form>

</body>

</html>
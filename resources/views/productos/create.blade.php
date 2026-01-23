<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear un producto</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-10 bg-gray-100">
    
<h1 class="text-2xl font-bold mb-6"> Crear producto </h1>

    <form action="{{ route('productos.store') }}" method="POST"
          class="bg-white p-6 rounded shadow w-96">
        @csrf

        <div class="mb-4">
            <x-atoms.label for="nombre">
                Nombre
            </x-atoms.label>

            <x-atoms.input name="nombre"/>
        </div>

        <div class="mb-4">
            <x-atoms.label for="precio">
                Precio
            </x-atoms.label>

            <x-atoms.input type="number" name="precio"/>
        </div>

        <x-atoms.button type="submit">
            Guardar producto
        </x-atoms.button>
    </form>

</body>
</html>
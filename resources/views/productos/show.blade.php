<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle del Producto</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <div class="max-w-6xl mx-auto p-6">
    <div class="bg-white rounded-2xl shadow-lg p-8 grid grid-cols-1 md:grid-cols-2 gap-10">

      <!-- Imagen del producto -->
      <div>
        <img 
          src="https://via.placeholder.com/600" 
          alt="Producto"
          class="w-full rounded-xl object-cover"
        >
      </div>

      <!-- Información del producto -->
      <div class="flex flex-col justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-4">
            {{ $producto->nombre }}
          </h1>

          <p class="text-2xl text-green-600 font-semibold mb-4">
            {{ $producto->precio }}
          </p>

          <p class="text-gray-600 mb-6 leading-relaxed">
            Este producto está diseñado para ofrecer la mejor experiencia.
            Fabricado con materiales de alta calidad y pensado para un uso
            cómodo y duradero.
          </p>

          <!-- Características -->
          <ul class="space-y-2 mb-6">
            <li class="flex items-center text-gray-700">
              <span class="text-green-500 mr-2">✔</span> Material premium
            </li>
            <li class="flex items-center text-gray-700">
              <span class="text-green-500 mr-2">✔</span> Garantía de 1 año
            </li>
            <li class="flex items-center text-gray-700">
              <span class="text-green-500 mr-2">✔</span> Diseño ergonómico
            </li>
            <li class="flex items-center text-gray-700">
              <span class="text-green-500 mr-2">✔</span> Envío rápido
            </li>
          </ul>
        </div>

        <!-- Acción -->
      </div>

    </div>
  </div>

</body>
</html>

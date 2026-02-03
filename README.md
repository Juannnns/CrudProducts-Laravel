# Sistema de Gestión de Productos

Este es un sistema robusto de gestión de productos desarrollado con **Laravel 12**, diseñado para ofrecer una experiencia fluida tanto para administradores como para usuarios finales. El sistema incluye gestión de categorías, galerías de imágenes, control de acceso basado en roles y una API completa.

## 🚀 Tecnologías Utilizadas

- **Framework:** Laravel 12
- **Frontend:** Livewire 3, TailwindCSS
- **Autenticación:** Laravel Jetstream (Sanctum)
- **Base de Datos:** SQLite (Configuración por defecto)
- **Pruebas:** Pest PHP

## ✨ Características Principales

- **Gestión de Productos (CRUD):** Creación, edición, visualización y eliminación de productos.
- **Categorización:** Organización de productos por categorías dinámicas.
- **Galería de Imágenes:** Cada producto soporta una imagen principal y hasta 5 imágenes adicionales en una galería.
- **Control de Acceso (RBAC):**
  - **Administradores:** Acceso total a todos los productos del sistema.
  - **Usuarios:** Gestión exclusiva de sus propios productos.
- **API RESTful:** Endpoints completos para integración con aplicaciones externas.
- **Paginación y Filtrado:** Localización eficiente de productos en la interfaz web.

## 🛠️ Instalación y Configuración

Sigue estos pasos para configurar el proyecto localmente:

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/Juannnns/CrudProducts-Laravel.git
   cd CrudProducts-Laravel
   ```

2. **Ejecutar el script de configuración automática:**
   Este comando instalará dependencias, configurará el entorno, generará llaves y ejecutará migraciones.
   ```bash
   composer run setup
   ```

3. **Iniciar el servidor de desarrollo:**
   Ejecuta el servidor, el procesador de colas y Vite simultáneamente:
   ```bash
   composer run dev
   ```

4. **Acceso:**
   Abre [http://localhost:8000](http://localhost:8000) en tu navegador.

## 🧪 Pruebas

Para ejecutar las pruebas automatizadas (Pest):
```bash
composer run test
```
Consulta la [Guía de Pruebas](Test%20Guide.md) para más detalles sobre la cobertura y ejecución.

## 🌐 API

El sistema expone una API para interactuar con los productos:

- **Público:** `/api/products` (GET), `/api/products/{id}` (GET)
- **Protegido (Sanctum):** `/api/products` (POST), `/api/products/{id}` (PUT/PATCH/DELETE)

Para una documentación detallada de los endpoints y ejemplos de uso, revisa el archivo [Api.md](Api.md).

## 📄 Licencia

Este proyecto es de código abierto bajo la licencia [MIT](LICENSE).

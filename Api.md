# API de Gestión de Productos

Esta es la documentación completa de la API REST para el sistema de gestión de productos.

## URL Base
```
http://localhost:8080/api
```

---

## 🚀 Inicio Rápido con Postman

### 1️⃣ Login (Obtener Token)

**Configuración en Postman:**
- **Método**: `POST`
- **URL**: `http://localhost:8080/api/login`
- **Headers**:
  - `Content-Type`: `application/json`
  - `Accept`: `application/json`
- **Body** (raw JSON):
```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

**Respuesta esperada:**
```json
{
  "success": true,
  "message": "Login exitoso",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com",
      "role": "admin"
    },
    "token": "1|n33AhgjFLrU0BXBMBKMCRDvMsCo6DNwoswUTa3p3d50422ac"
  }
}
```

> **✅ IMPORTANTE**: Copia el `token` que recibes. Lo necesitarás para todas las demás peticiones.

---

### 2️⃣ Usar el Token en Otras Peticiones

Para **cualquier** otra petición a la API, debes agregar el token:

**En Postman:**
1. Ve a la pestaña **Headers**
2. Agrega:
   - **Key**: `Authorization`
   - **Value**: `Bearer {tu-token-aquí}`

```
Authorization: Bearer 1|n33AhgjFLrU0BXBMBKMCRDvMsCo6DNwoswUTa3p3d50422ac
```

---

### 3️⃣ Logout (Desautenticarse)

**Configuración en Postman:**
- **Método**: `POST`
- **URL**: `http://localhost:8080/api/logout`
- **Headers**:
  - `Authorization`: `Bearer {tu-token}`

**Respuesta esperada:**
```json
{
  "success": true,
  "message": "Logout exitoso"
}
```

> ⚠️ **Después del logout**, ese token queda **invalidado** y ya no funcionará. Deberás hacer login nuevamente para obtener un nuevo token.

---

## Autenticación

La API utiliza **Laravel Sanctum** para autenticación mediante tokens Bearer. **Todas las rutas de productos requieren autenticación**.

### 🔐 Login (Obtener Token)
**POST** `/api/login`

Endpoint público para obtener un token de autenticación.

**Campos del Body:**
- `email` (string, requerido): Email del usuario
- `password` (string, requerido): Contraseña

**Ejemplo de Request:**
```bash
curl -X POST http://localhost:8080/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password"
  }'
```

**Ejemplo de Response:**
```json
{
  "success": true,
  "message": "Login exitoso",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com",
      "role": "admin"
    },
    "token": "1|n33AhgjFLrU0BXBMBKMCRDvMsCo6DNwoswUTa3p3d50422ac"
  }
}
```

> **IMPORTANTE**: Guarda el `token` que recibes. Lo necesitarás para todas las demás peticiones.

---

### 🚪 Logout (Revocar Token)
**POST** `/api/logout`

Revoca el token actual del usuario autenticado.

**Headers Requeridos:**
```
Authorization: Bearer {token}
```

**Ejemplo de Request:**
```bash
curl -X POST http://localhost:8080/api/logout \
  -H "Authorization: Bearer 1|n33AhgjFLrU0BXBMBKMCRDvMsCo6DNwoswUTa3p3d50422ac"
```

**Ejemplo de Response:**
```json
{
  "success": true,
  "message": "Logout exitoso"
}
```

---

### 👤 Información del Usuario Autenticado
**GET** `/api/me`

Obtiene la información del usuario autenticado.

**Headers Requeridos:**
```
Authorization: Bearer {token}
```

**Ejemplo de Request:**
```bash
curl -X GET http://localhost:8080/api/me \
  -H "Authorization: Bearer 1|n33AhgjFLrU0BXBMBKMCRDvMsCo6DNwoswUTa3p3d50422ac"
```

**Ejemplo de Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@example.com",
    "role": "admin"
  }
}
```

---

## Cómo Usar el Token

Una vez que hayas obtenido el token mediante `/api/login`, debes incluirlo en **todas** las peticiones protegidas usando el header `Authorization`:

```
Authorization: Bearer {tu-token-aquí}
```

### Ejemplo con cURL:
```bash
curl -X GET http://localhost:8080/api/products \
  -H "Authorization: Bearer 1|n33AhgjFLrU0BXBMBKMCRDvMsCo6DNwoswUTa3p3d50422ac" \
  -H "Accept: application/json"
```

### Ejemplo con Postman/Thunder Client:
1. Ve a la pestaña **Headers**
2. Agrega:
   - **Key**: `Authorization`
   - **Value**: `Bearer {tu-token}`

---

## Endpoints Disponibles

### 📋 Listar Productos
**GET** `/api/products`

Lista todos los productos (paginados, 10 por página). **Requiere autenticación.**

**Permisos:**
- Si estás autenticado como **admin**: verás todos los productos
- Si estás autenticado como **user**: verás solo tus productos

**Headers Requeridos:**
```
Authorization: Bearer {token}
```

**Ejemplo de Request:**
```bash
curl -X GET http://localhost:8080/api/products \
  -H "Authorization: Bearer {tu-token}" \
  -H "Accept: application/json"
```

**Ejemplo de Response:**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "nombre": "iPhone 15 Pro",
        "precio": "999.99",
        "description": "Latest iPhone model",
        "image_path": "products/abc123.jpg",
        "category_id": 1,
        "user_id": 1,
        "created_at": "2026-02-03T14:00:00.000000Z",
        "updated_at": "2026-02-03T14:00:00.000000Z",
        "category": {
          "id": 1,
          "name": "Electrónicos"
        }
      }
    ],
    "per_page": 10,
    "total": 25
  }
}
```

---

### 🔍 Ver Producto Específico
**GET** `/api/products/{id}`

Obtiene los detalles de un producto específico. **Requiere autenticación.**

**Parámetros de URL:**
- `id` (integer, requerido): ID del producto

**Headers Requeridos:**
```
Authorization: Bearer {token}
```

**Ejemplo de Request:**
```bash
curl -X GET http://localhost:8080/api/products/1 \
  -H "Authorization: Bearer {tu-token}" \
  -H "Accept: application/json"
```

**Ejemplo de Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nombre": "iPhone 15 Pro",
    "precio": "999.99",
    "description": "Latest iPhone model",
    "image_path": "products/abc123.jpg",
    "category_id": 1,
    "user_id": 1,
    "created_at": "2026-02-03T14:00:00.000000Z",
    "updated_at": "2026-02-03T14:00:00.000000Z",
    "category": {
      "id": 1,
      "name": "Electrónicos"
    },
    "user": {
      "id": 1,
      "name": "Juan Pérez"
    },
    "images": [
      {
        "id": 1,
        "image_path": "product_gallery/gallery1.jpg"
      }
    ]
  }
}
```

---

### ➕ Crear Producto
**POST** `/api/products`

Crea un nuevo producto. **Requiere autenticación.**

**Headers Requeridos:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
Accept: application/json
```

**Campos del Body:**
- `nombre` (string, requerido): Nombre del producto
- `precio` (numeric, requerido): Precio del producto
- `category_id` (integer, requerido): ID de la categoría
- `description` (string, opcional): Descripción del producto
- `image` (file, requerido): Imagen principal del producto
- `gallery[]` (array de files, opcional): Imágenes de galería (máximo 5)

**Ejemplo de Request:**
```bash
curl -X POST http://localhost:8080/api/products \
  -H "Authorization: Bearer {tu-token}" \
  -H "Accept: application/json" \
  -F "nombre=MacBook Pro" \
  -F "precio=2499.99" \
  -F "category_id=1" \
  -F "description=Laptop premium" \
  -F "image=@/ruta/a/imagen.jpg" \
  -F "gallery[]=@/ruta/a/galeria1.jpg" \
  -F "gallery[]=@/ruta/a/galeria2.jpg"
```

**Ejemplo de Response:**
```json
{
  "success": true,
  "message": "Producto creado exitosamente",
  "data": {
    "id": 10,
    "nombre": "MacBook Pro",
    "precio": "2499.99",
    "description": "Laptop premium",
    "image_path": "products/xyz789.jpg",
    "category_id": 1,
    "user_id": 1,
    "created_at": "2026-02-03T14:30:00.000000Z",
    "updated_at": "2026-02-03T14:30:00.000000Z",
    "category": {
      "id": 1,
      "name": "Electrónicos"
    },
    "images": [
      {
        "id": 15,
        "image_path": "product_gallery/gallery1.jpg"
      }
    ]
  }
}
```

---

### ✏️ Actualizar Producto
**PUT/PATCH** `/api/products/{id}`

Actualiza un producto existente. **Requiere autenticación.** Solo puedes actualizar tus propios productos (o todos si eres admin).

**Headers Requeridos:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
Accept: application/json
```

**Campos del Body:**
- `nombre` (string, opcional): Nombre del producto
- `precio` (numeric, opcional): Precio del producto
- `category_id` (integer, opcional): ID de la categoría
- `description` (string, opcional): Descripción del producto
- `image` (file, opcional): Nueva imagen principal
- `gallery[]` (array de files, opcional): Nuevas imágenes de galería
- `delete_images[]` (array de integers, opcional): IDs de imágenes de galería a eliminar

**Ejemplo de Request:**
```bash
curl -X PUT http://localhost:8080/api/products/10 \
  -H "Authorization: Bearer {tu-token}" \
  -H "Accept: application/json" \
  -F "nombre=MacBook Pro M3" \
  -F "precio=2699.99" \
  -F "description=Laptop premium con chip M3"
```

**Ejemplo de Response:**
```json
{
  "success": true,
  "message": "Producto actualizado exitosamente",
  "data": {
    "id": 10,
    "nombre": "MacBook Pro M3",
    "precio": "2699.99",
    "description": "Laptop premium con chip M3",
    "image_path": "products/xyz789.jpg",
    "category_id": 1,
    "user_id": 1,
    "created_at": "2026-02-03T14:30:00.000000Z",
    "updated_at": "2026-02-03T15:00:00.000000Z"
  }
}
```

---

### 🗑️ Eliminar Producto
**DELETE** `/api/products/{id}`

Elimina un producto. **Requiere autenticación.** Solo puedes eliminar tus propios productos (o todos si eres admin).

**Headers Requeridos:**
```
Authorization: Bearer {token}
Accept: application/json
```

**Ejemplo de Request:**
```bash
curl -X DELETE http://localhost:8080/api/products/10 \
  -H "Authorization: Bearer {tu-token}" \
  -H "Accept: application/json"
```

**Ejemplo de Response:**
```json
{
  "success": true,
  "message": "Producto eliminado exitosamente"
}
```

---

## Códigos de Estado HTTP

La API utiliza los siguientes códigos de estado:

- `200 OK` - Solicitud exitosa (GET, PUT, PATCH)
- `201 Created` - Recurso creado exitosamente (POST)
- `401 Unauthorized` - No autenticado o token inválido
- `403 Forbidden` - No tienes permiso para realizar esta acción
- `404 Not Found` - Producto no encontrado
- `422 Unprocessable Entity` - Error de validación

## Ejemplos de Errores

### Error de Validación (422)
```json
{
  "message": "The nombre field is required. (and 1 more error)",
  "errors": {
    "nombre": [
      "The nombre field is required."
    ],
    "precio": [
      "The precio field is required."
    ]
  }
}
```

### Error de Autenticación (401)
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

### Error de Autorización (403)
```json
{
  "success": false,
  "message": "No autorizado"
}
```

### Producto No Encontrado (404)
```json
{
  "success": false,
  "message": "Producto no encontrado"
}
```

---

## Probar la API

### Usando Postman

1. Importa la colección de Postman (puedes crearla con los endpoints de arriba)
2. Configura el token de autenticación en el header `Authorization`
3. Prueba cada endpoint

### Usando cURL

Todos los ejemplos de arriba utilizan cURL y pueden ejecutarse directamente en la terminal.

### Usando Thunder Client (VSCode)

1. Instala la extensión Thunder Client
2. Crea las solicitudes según los ejemplos de arriba
3. Guarda el token de autenticación en el entorno

---

## Notas Importantes

1. **Prefijo de API**: Todas las rutas API tienen el prefijo `/api/`
2. **Autenticación**: Las rutas POST, PUT, PATCH y DELETE requieren autenticación
3. **Permisos**: Los usuarios solo pueden modificar/eliminar sus propios productos (excepto admins)
4. **Paginación**: Los listados están paginados con 10 elementos por página
5. **Imágenes**: Las imágenes se almacenan en `storage/app/public/products` y `storage/app/public/product_gallery`

---

## Testing con Postman - Paso a Paso

1. **Registrar un usuario** (desde el navegador web)
2. **Login** y obtener el token
3. **Configurar Postman**:
   - En Headers, agregar: `Authorization: Bearer {token}`
   - En Headers, agregar: `Accept: application/json`
4. **Probar endpoints**: GET, POST, PUT, DELETE

¡Tu API está lista para usar! 🚀

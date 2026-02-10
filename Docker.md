# Comandos de Docker para el Proyecto

Este archivo contiene los comandos necesarios para gestionar el entorno de desarrollo con Docker.

## Opción Recomendada: Usar Makefile

Hemos creado un archivo `Makefile` para simplificar los comandos. Puedes usar los siguientes atajos en tu terminal:

| Acción | Comando Make | Comando Equivalente |
|--------|--------------|---------------------|
| **Levantar** | `make up` | `sudo docker compose up -d` |
| **Frenar** | `make down` | `sudo docker compose down` |
| **Actualizar/Rebuild** | `make build` | `sudo docker compose up -d --build` |
| **Ver Logs** | `make logs` | `sudo docker compose logs -f` |
| **Entrar al Contenedor** | `make bash` | `sudo docker compose exec app bash` |
| **Limpiar Caché** | `make cache` | `php artisan config:clear` + `cache:clear` |

### Ejecutar comandos Artisan personalizados

Para ejecutar un comando específico de artisan:

```bash
make artisan cmd="migrate"
make artisan cmd="make:controller ProductController"
```

---

## Opción Manual: Comandos Directos

Si prefieres no usar `make`, utiliza los comandos completos de Docker Compose V2:

### 1. Levantar el Docker (Start)

```bash
sudo docker compose up -d
```

### 2. Frenar el Docker (Stop)

```bash
sudo docker compose down
```

### 3. Actualizar el Docker (Update/Rebuild)

```bash
sudo docker compose up -d --build
```

### 4. Ver Logs

```bash
sudo docker compose logs -f
```

### 5. Ejecutar Comandos de Artisan

```bash
sudo docker compose exec app php artisan <comando>
```

Ejemplos comunes:

```bash
# Migraciones
sudo docker compose exec app php artisan migrate

# Limpiar caché
sudo docker compose exec app php artisan config:clear
sudo docker compose exec app php artisan cache:clear
```

### 6. Instalar Dependencias

```bash
# Composer (PHP)
sudo docker compose exec app composer install

# NPM (Node)
sudo docker compose exec app npm install
```

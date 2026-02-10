# Makefile para simplificar comandos de Docker

# Levantar contenedores
up:
	sudo docker compose up -d

# Detener contenedores
down:
	sudo docker compose down

# Reconstruir contenedores
build:
	sudo docker compose up -d --build

# Ver logs
logs:
	sudo docker compose logs -f

# Ejecutar Artisan (uso: make artisan cmd="migrate")
artisan:
	sudo docker compose exec app php artisan $(cmd)

# Limpiar caché
cache:
	sudo docker compose exec app php artisan config:clear
	sudo docker compose exec app php artisan cache:clear

# Entrar a la terminal del contenedor app
bash:
	sudo docker compose exec app bash

# Instalar dependencias de Composer
composer-install:
	sudo docker compose exec app composer install

# Instalar dependencias de NPM
npm-install:
	sudo docker compose exec app npm install

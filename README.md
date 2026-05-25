# AlvGluten - Tienda en Línea

Plataforma de comercio electrónico diseñada especialmente para la comunidad celíaca. Desarrollada con Laravel, Livewire y Tailwind CSS.

##  Tecnologías Principales
* **Backend:** PHP, Laravel
* **Frontend:** Laravel Livewire 3, Tailwind CSS
* **Base de Datos:** MySQL
* **Entorno:** Docker (Contenedores)

##  Requisitos Previos
Para levantar este proyecto, necesitas tener instalado:
* Docker y Docker Compose
* Git

##  Instalación y Configuración

1. **Clonar el repositorio:**
   `git clone https://github.com/IvanSamnuelOrtizOrellana/AlvGluten_final-.git`
   `cd AlvGluten_final-`

2. **Configurar el entorno:**
   `cp .env.example .env`

3. **Levantar los contenedores de Docker:**
   `docker compose up -d`

4. **Instalar dependencias de PHP:**
   `docker compose exec app composer install`

5. **Generar la clave de la aplicación:**
   `docker compose exec app php artisan key:generate`

6. **Migrar y poblar la base de datos:**
   `docker compose exec app php artisan migrate:fresh --seed`

7. **Crear el enlace para ver las imágenes:**
   `docker compose exec app php artisan storage:link`

##  Pruebas Automatizadas (Testing)
El sistema cuenta con 11 pruebas (TDD) que validan el flujo de compra. Para ejecutarlas:
`docker compose exec app php artisan test tests/Feature/AlvGlutenTest.php`

# Despliegue Básico de Laravel 12 (API) - Todo App

## Requisitos Previos

- PHP >= 8.2
- Composer
- MySQL
- Node.js (bun) y npm (opcional, Para desplegar el frontend)

## Pasos de Despliegue

### 1. Clonar el repositorio

```bash
git clone https://github.com/JulianLlanten8/appTodo.git
cd appTodo/Backend
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar variables de entorno

Copia el archivo `.env.example` a `.env` y edítalo con tus credenciales:

```bash
cp .env.example .env
```

Configura la conexión a la base de datos en `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generar clave de aplicación

```bash
php artisan key:generate
```

### 5. Migrar la base de datos

```bash
php artisan migrate
```

### 6. Configurar permisos

```bash
chmod -R 775 storage bootstrap/cache
```

### 7. Iniciar el servidor (opcional)

```bash
php artisan serve
```

## Notas

- Esta aplicación es solo API, no incluye vistas.

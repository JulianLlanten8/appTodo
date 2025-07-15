# Despliegue Básico de Laravel 12 (API) - Todo App

## Requisitos Previos

- PHP >= 8.2
- Composer
- MySQL o PostgreSQL
- Servidor web (Nginx o Apache)
- Node.js y npm (opcional, solo si usas herramientas de frontend)

## Pasos de Despliegue

### 1. Clonar el repositorio

```bash
git clone https://github.com/usuario/todo-app.git
cd todo-app
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

### 7. Configurar el servidor web

Configura tu servidor web para apuntar al directorio `public/` del proyecto.

### 8. Iniciar el servidor (opcional)

```bash
php artisan serve
```

## Notas

- Esta aplicación es solo API, no incluye vistas.
- Asegúrate de proteger tus endpoints con autenticación si es necesario.

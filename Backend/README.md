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

### 8. Ejecutar Pint (opcional) - Este comando ejecuta Pint, que es un formateador de código para PHP, con el fin de que el código siga las convenciones de estilo de Laravel.
```bash
php artisan lint
```


> [!IMPORTANT]
> - Esta aplicación es solo API, no incluye vistas ya que se creo el frontend con React.
> - Adjunto encontrara una collection de Postman para probar los endpoints de la API Dentro de la carpeta `Docs`, la cual contiene ejemplos de peticiones y respuestas y podra importarla directamente en Postman o cualquier herramienta similar.

### 9. Probar la API
Puedes probar la API utilizando Postman o cualquier cliente HTTP. Aquí tienes un ejemplo de cómo hacer una solicitud GET listar tareas:
```bash
curl -X GET http://localhost:8000/api/tasks
```

### 10. Notas
- El flujo de creación de tareas es el siguiente:
  - 1. Frontend (React) → API Request
  - 2. TaskController::store() → CreateTaskUseCase::execute(), se recibe la petición del frontend.
  - 3. CreateTaskUseCase → TaskService::createTaskWithDetails(), se encarga de la lógica de negocio.
  - 4. TaskService → TaskRepositoryInterface (EloquentTaskRepository), se comunica con el repositorio.
  - 5. EloquentTaskRepository → Base de datos, se encarga de las operaciones CRUD.
- Así se sigue el flujo de una API RESTful con arquitectura Hexagonal, donde el controlador se comunica con el caso de uso, el caso de uso con el servicio de dominio y el servicio de dominio con el repositorio.
- **Configuración importante**: El TaskService está registrado en el AppServiceProvider para que Laravel pueda resolver sus dependencias automáticamente.

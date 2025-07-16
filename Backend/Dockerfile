FROM php:8.3-fpm

# Instala dependencias de sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip \
    libzip-dev libpq-dev libjpeg-dev libfreetype6-dev libjpeg62-turbo-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crea directorio app
WORKDIR /var/www

# Copia los archivos del proyecto
COPY . .

# Instala dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Permisos de Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Puerto en el que correrá Laravel
EXPOSE 8000

# Comando de inicio
CMD ["/bin/sh", "-c", "echo 'APP_KEY=' > .env && php artisan key:generate && php artisan config:cache && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]


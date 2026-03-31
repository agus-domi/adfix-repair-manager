# 1. Usar una imagen oficial de PHP
FROM php:8.2-cli

# 2. Instalar dependencias necesarias para Laravel y Node.js para compilar Vite
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libpq-dev \
    zip unzip git curl sqlite3 libsqlite3-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# 3. Configurar e instalar extensiones de PHP requeridas
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql pdo_sqlite zip

# 4. Instalar Composer (Gestor de paquetes PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Establecer el directorio de trabajo
WORKDIR /var/www/html

# 6. Copiar los archivos del proyecto de tu compu al contenedor (excepto lo del .dockerignore)
COPY . .

# 7. Instalar dependencias de PHP y optimizar para producción
RUN composer install --no-interaction --no-dev --optimize-autoloader

# 8. Instalar dependencias de JavaScript y compilar CSS/Vite/Tailwind
RUN npm install && npm run build

# 9. Preparar SQLite y dar permisos de escritura a las carpetas críticas
RUN touch database/database.sqlite \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 777 storage bootstrap/cache database

# 10. Exponer el puerto que dictará Render
ENV PORT=10000
EXPOSE ${PORT}

# 11. Arranque: corre las migraciones de los datos y levanta el servidor
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT}

# Etapa 1: build de frontend con Node.js 22
FROM node:22-alpine AS node-builder

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --silent

COPY . .
RUN npm run build

# Etapa 2: Laravel con imagen optimizada
FROM serversideup/php:8.2-fpm-nginx

# Cambiar al usuario root para instalaciones
USER root

# Instalar SQLite
RUN apt-get update && apt-get install -y \
    sqlite3 \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Limpiar directorio
RUN rm -rf /var/www/html/*

# Copiar archivos de Laravel
COPY --chown=www-data:www-data . .

# Copiar archivos del build de frontend
COPY --from=node-builder --chown=www-data:www-data /app/public /var/www/html/public

# Instalar dependencias de Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Crear directorios y archivos necesarios
RUN mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache database && \
    touch database/database.sqlite

# Configurar permisos
RUN chown -R www-data:www-data storage bootstrap/cache database && \
    chmod -R 775 storage bootstrap/cache && \
    chmod 664 database/database.sqlite

# Generar .env desde .env.example si no existe
RUN if [ ! -f .env ] && [ -f .env.example ]; then cp .env.example .env; fi

# Generar APP_KEY
RUN php artisan key:generate --force

# Ejecutar migraciones (si fallan, continuamos)
RUN php artisan migrate --force || true

# Cachear configuración
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Variables de entorno
ENV PHP_OPCACHE_ENABLE=1
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=/var/www/html/database/database.sqlite

# Volver al usuario www-data
USER www-data

# Exponer puerto 80
EXPOSE 80

COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]

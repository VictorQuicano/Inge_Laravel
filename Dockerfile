# Etapa 1: build de frontend con Node.js 22
FROM node:22-alpine as node-builder

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run build


# Etapa 2: Laravel + nginx + PHP
FROM richarvey/nginx-php-fpm:3.1.6

# Copia el código fuente
COPY . /var/www/html

# Copia los assets compilados
COPY --from=node-builder /app/public /var/www/html/public

# Crea base de datos SQLite
RUN touch /var/www/html/database/database.sqlite && \
    chown www-data:www-data /var/www/html/database/database.sqlite && \
    chmod 664 /var/www/html/database/database.sqlite

# Variables de entorno
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=/var/www/html/database/database.sqlite

# Copia script y da permisos
COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]

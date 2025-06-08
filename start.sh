#!/bin/bash

echo "Running composer"
composer install --no-interaction

echo "Generating application key..."
php artisan key:generate

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Seeding DB..."
php artisan db:seed --force

echo "Starting Nginx and PHP-FPM..."
exec supervisord -n

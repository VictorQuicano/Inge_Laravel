#!/usr/bin/env bash
set -e

SQLITE_DB_PATH="/var/www/html/database/database.sqlite"

if [ "$DB_CONNECTION" = "sqlite" ]; then
  if [ ! -f "$SQLITE_DB_PATH" ]; then
    echo "Creating SQLite database file at $SQLITE_DB_PATH"
    touch "$SQLITE_DB_PATH"
    chown www-data:www-data "$SQLITE_DB_PATH"
    chmod 664 "$SQLITE_DB_PATH"
  fi
fi

echo "Running composer"
composer install --no-dev --working-dir=/var/www/html

echo "Generating application key..."
php artisan key:generate --show

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Seeding DB..."
php artisan db:seed

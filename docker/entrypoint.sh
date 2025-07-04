#!/bin/bash

echo "🏁 Starting Laravel entrypoint..."

# Optional: run composer install if vendor is missing
if [ ! -d "/var/www/html/vendor" ]; then
  echo "📦 Running composer install..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

chmod -R 777 /var/www/storage /var/www/bootstrap/cache

php artisan config:clear
php artisan migrate --force
exec docker-php-entrypoint php-fpm
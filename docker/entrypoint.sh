#!/bin/bash

echo "🏁 Starting Laravel entrypoint..."

# Optional: run composer install if vendor is missing
if [ ! -d "/var/www/html/vendor" ]; then
  echo "📦 Running composer install..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

chmod -R 777 /var/www/bootstrap/cache
chmod -R 777 /var/www/storage
chmod 600 /var/www/storage/oauth-private.key

php artisan config:clear
php artisan migrate --force --seed
exec docker-php-entrypoint php-fpm

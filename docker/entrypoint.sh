#!/bin/bash

echo "🏁 Starting Laravel entrypoint..."

# Optional: run composer install if vendor is missing
if [ ! -d "/var/www/html/vendor" ]; then
  echo "📦 Running composer install..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

chmod -R 777 /var/www/bootstrap/cache
chmod -R 777 /var/www/storage
chown www-data:www-data /var/www/storage/oauth-*.key
chmod 660 /var/www/storage/oauth-private.key

php artisan config:cleare
php artisan migrate --force --seed
php artisan migrate --force --env=testing
php artisan passport:keys --force
php artisan passport:client --personal --no-interaction
exec docker-php-entrypoint php-fpm

#!/bin/sh
set -e

mkdir -p \
  storage/app/public \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/testing \
  storage/framework/views \
  storage/logs \
  bootstrap/cache \
  public/upload

if [ -d /usr/local/share/hotel-public-upload ] && [ -z "$(ls -A public/upload 2>/dev/null)" ]; then
  cp -a /usr/local/share/hotel-public-upload/. public/upload/
fi

chown -R www-data:www-data storage bootstrap/cache public/upload

if [ "${RUN_LARAVEL_OPTIMIZE:-false}" = "true" ]; then
  php artisan config:cache
  php artisan view:cache
fi

exec "$@"

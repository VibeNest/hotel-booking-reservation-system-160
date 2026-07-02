# syntax=docker/dockerfile:1.7

FROM node:22-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN npm run build

FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --optimize-autoloader

FROM php:8.2-fpm-bookworm AS app
WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" bcmath exif gd opcache pcntl pdo_mysql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=vendor /app/vendor ./vendor
COPY . .
COPY --from=frontend /app/public/build ./public/build
COPY docker/php/php.ini /usr/local/etc/php/conf.d/production.ini
COPY docker/entrypoint.sh /usr/local/bin/hotel-entrypoint

RUN cp -a public/upload /usr/local/share/hotel-public-upload \
    && chmod +x /usr/local/bin/hotel-entrypoint \
    && mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/testing storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache public/upload

ENTRYPOINT ["hotel-entrypoint"]
CMD ["php-fpm"]

FROM nginx:1.27-alpine AS nginx
WORKDIR /var/www/html
COPY --from=app /var/www/html/public ./public
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

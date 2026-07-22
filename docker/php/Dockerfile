FROM php:8.3-fpm-alpine

# Dépendances système nécessaires aux extensions PHP et à Composer
RUN apk add --no-cache \
        git \
        unzip \
        icu-dev \
        libzip-dev \
        oniguruma-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        intl \
        zip \
        opcache

# Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Configuration PHP adaptée à l'environnement de test
COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini

COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-scripts \
    && mkdir -p var/cache var/log \
    && chown -R www-data:www-data var

USER www-data

EXPOSE 9000

CMD ["php-fpm"]

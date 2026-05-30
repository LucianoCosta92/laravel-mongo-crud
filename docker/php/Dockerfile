FROM php:8.4-fpm-alpine AS base

RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    libzip-dev \
    oniguruma-dev \
    autoconf \
    g++ \
    make

RUN docker-php-ext-install \
    pdo \
    mbstring \
    zip \
    bcmath

RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

RUN pecl install redis \
    && docker-php-ext-enable redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

FROM base AS app

WORKDIR /var/www

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --prefer-dist

COPY . .

RUN composer dump-autoload --optimize

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]

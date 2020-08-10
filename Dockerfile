####
## Base stage, to empower cache
####
FROM php:7.4-apache as base

WORKDIR /var/www/app.com

COPY ./.docker/apache/apache.conf /etc/apache2/sites-available/000-default.conf

# Install php extensions
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        g++ \
        default-mysql-client \
        zlib1g-dev \
        libicu-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        sudo \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install gd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install exif \
    && pecl -q install \
        zip \
    && docker-php-ext-enable zip opcache



# Installing composer and prestissimo globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1 COMPOSER_MEMORY_LIMIT=-1
RUN composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --classmap-authoritative --no-plugins --no-scripts

RUN composer install --prefer-dist --no-scripts --no-progress --no-suggest

RUN mkdir -p ./var/cache \
    ./var/log \
    ./var/sessions \
    ./var/demo \
    ./public/ \
        && chown -R www-data ./var \
        && chown -R www-data ./public

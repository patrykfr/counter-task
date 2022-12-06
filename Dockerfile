FROM php:8.1.0-fpm
RUN apt-get update && apt-get install -y git \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip pdo_mysql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www

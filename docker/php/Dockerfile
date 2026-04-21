FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        unzip \
        zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && pecl install igbinary redis \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        fileinfo \
        gd \
        mysqli \
        pdo_mysql \
        zip \
    && docker-php-ext-enable igbinary redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . /var/www/html

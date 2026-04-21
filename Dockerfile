FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        libcurl4-openssl-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
        libpng-dev \
        libzip-dev \
        unzip \
        zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && pecl install igbinary redis \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        curl \
        fileinfo \
        gd \
        mbstring \
        mysqli \
        pdo_mysql \
        simplexml \
        xml \
        xmlreader \
        xmlwriter \
        zip \
    && docker-php-ext-enable igbinary redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . /app

RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader \
    && test -f /app/thinkphp/start.php

ENV PORT=8080

RUN mkdir -p /app/runtime/cache /app/runtime/log /app/runtime/temp

EXPOSE 8080

CMD ["sh", "-c", "php -d variables_order=EGPCS -S 0.0.0.0:${PORT:-8080} -t public public/router.php"]

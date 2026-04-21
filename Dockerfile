FROM php:8.2-apache

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
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html

RUN composer install --no-dev --prefer-source --no-interaction --optimize-autoloader -vvv \
    && test -f /var/www/html/thinkphp/start.php \
    && mkdir -p /var/www/html/runtime/cache /var/www/html/runtime/log /var/www/html/runtime/temp \
    && chown -R www-data:www-data /var/www/html/runtime

EXPOSE 8080

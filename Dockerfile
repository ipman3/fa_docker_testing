FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libcurl4-openssl-dev \
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
        curl \
        fileinfo \
        gd \
        mysqli \
        pdo_mysql \
        zip \
    && docker-php-ext-enable igbinary redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY . /app

ENV PORT=8080

RUN mkdir -p /app/runtime/cache /app/runtime/log /app/runtime/temp

EXPOSE 8080

CMD ["sh", "-c", "php -d variables_order=EGPCS -S 0.0.0.0:${PORT:-8080} -t public public/router.php"]

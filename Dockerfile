FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        nginx \
        libcurl4-openssl-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libxml2-dev \
        libzip-dev \
        unzip \
        zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && pecl install igbinary redis \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        curl \
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
    && { \
        echo 'server {'; \
        echo '    listen 80;'; \
        echo '    server_name _;'; \
        echo '    root /var/www/html/public;'; \
        echo '    index index.php index.html;'; \
        echo '    location / {'; \
        echo '        try_files $uri $uri/ /index.php?s=$query_string;'; \
        echo '    }'; \
        echo '    location ~ \\.php$ {'; \
        echo '        include fastcgi_params;'; \
        echo '        fastcgi_pass 127.0.0.1:9000;'; \
        echo '        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;'; \
        echo '        fastcgi_index index.php;'; \
        echo '    }'; \
        echo '    location ~* \\.(jpg|jpeg|gif|png|css|js|ico|xml)$ {'; \
        echo '        expires 7d;'; \
        echo '    }'; \
        echo '    location ~ /\\.ht {'; \
        echo '        deny all;'; \
        echo '    }'; \
        echo '}'; \
    } > /etc/nginx/conf.d/default.conf \
    && rm -f /etc/nginx/sites-enabled/default \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

COPY . .

RUN test -f /var/www/html/thinkphp/start.php \
    && mkdir -p /var/www/html/runtime/cache /var/www/html/runtime/log /var/www/html/runtime/temp \
    && chown -R www-data:www-data /var/www/html/runtime

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]


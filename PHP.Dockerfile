FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       git \
       unzip \
       libzip-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php \
    && rm -rf /var/lib/apt/lists/*

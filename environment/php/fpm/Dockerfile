FROM php:8.0-fpm-buster
MAINTAINER Tzvetelin Tzvetkov "tzvetelin.tzvetkov@gmail.com"

ARG SERVICE

RUN DEBIAN_FRONTEND=noninteractive apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y --no-install-recommends \
        libssl-dev \
        zlib1g-dev \
        libev-dev \
        git \
        unzip \
        libxml2-dev \
        libzip-dev && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-install -j$(nproc) zip opcache intl bcmath && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# install latest composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY environment/php/fpm/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN curl -L https://cs.symfony.com/download/php-cs-fixer-v2.phar -o php-cs-fixer && \
        chmod a+x php-cs-fixer && \
        mv php-cs-fixer /usr/local/bin/php-cs-fixer

RUN curl -sS https://get.symfony.com/cli/installer | bash

WORKDIR /var/www/html
ENTRYPOINT ["./entrypoint.sh"]

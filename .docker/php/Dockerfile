ARG PHP_VERSION=7.4

FROM php:${PHP_VERSION}-fpm

RUN apt-get update && apt-get install -y \
    zip  \
    unzip \
    git \
    npm \
    nano \
    && docker-php-ext-install pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

COPY ../../. .

# Remove APT cache
RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN chmod +x .docker/run/entrypoint.sh

ENTRYPOINT ["sh",".docker/run/entrypoint.sh"]
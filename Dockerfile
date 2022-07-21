FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    npm \
    nano \
    && docker-php-ext-install pdo_mysql

COPY ../../. .

RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN chmod +x docker/docker-entrypoint.sh

ENTRYPOINT ["sh","docker/docker-entrypoint.sh"]